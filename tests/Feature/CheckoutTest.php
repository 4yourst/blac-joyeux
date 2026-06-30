<?php

namespace Tests\Feature;

use App\Models\DeliveryOption;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Cahier de recettage (doc §11) — panier, livraison, coordonnées, enregistrement.
 */
class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /** Critère 6 — Ajout au panier : intention d'achat, sans précommande (aucune commande créée). */
    public function test_l_ajout_au_panier_ne_cree_pas_de_commande(): void
    {
        $product = Product::where('slug', 'joyau-de-bla-sac-de-bureau')->first();

        $this->post(route('cart.add', $product), ['quantity' => 2])
            ->assertRedirect(route('cart.index'));

        // Aucune commande n'est enregistrée à ce stade (pas de précommande).
        $this->assertDatabaseCount('orders', 0);

        // Le panier contient bien l'article.
        $this->get(route('cart.index'))
            ->assertOk()
            ->assertSee('Joyau de Bla — Sac de bureau')
            ->assertSee('170 000 FCFA'); // 2 × 85 000
    }

    /** Critère 7 — Options de livraison sélectionnables à la finalisation. */
    public function test_la_page_de_finalisation_propose_les_options_de_livraison(): void
    {
        $product = Product::where('slug', 'joyau-de-bla-cabas')->first();
        $this->post(route('cart.add', $product), ['quantity' => 1]);

        $response = $this->get(route('checkout.create'))->assertOk();

        foreach (DeliveryOption::where('is_active', true)->get() as $option) {
            $response->assertSee($option->zone);
        }
    }

    /** Critère 8 — Saisie des coordonnées : validation des champs obligatoires. */
    public function test_la_finalisation_valide_les_coordonnees(): void
    {
        $product = Product::first();
        $this->post(route('cart.add', $product), ['quantity' => 1]);

        $this->post(route('checkout.store'), [])
            ->assertSessionHasErrors(['customer_name', 'customer_phone', 'customer_address', 'delivery_option_id']);

        $this->assertDatabaseCount('orders', 0);
    }

    /** Critère 9 — La commande est enregistrée comme intention AVANT le choix de la voie. */
    public function test_la_commande_est_enregistree_avant_le_choix_de_la_voie(): void
    {
        $product = Product::where('slug', 'joyau-de-bla-sac-de-bureau')->first();
        $delivery = DeliveryOption::orderBy('price')->first();
        $this->post(route('cart.add', $product), ['quantity' => 2]);

        $this->post(route('checkout.store'), [
            'customer_name' => 'Awa Koné',
            'customer_phone' => '+225 0700000000',
            'customer_address' => 'Cocody, Abidjan',
            'delivery_option_id' => $delivery->id,
        ])->assertRedirect();

        $order = Order::latest()->first();

        $this->assertNotNull($order);
        $this->assertSame('pending', $order->status);
        $this->assertNull($order->conversion_channel);   // Voie pas encore choisie
        $this->assertNull($order->payment_method_id);     // Paiement pas encore défini
        $this->assertSame(2 * 85000 + $delivery->price, $order->total_amount);
        $this->assertCount(1, $order->items);
        $this->assertSame(85000, $order->items->first()->unit_price);

        // Le panier est vidé après enregistrement.
        $this->get(route('cart.index'))->assertSee('Votre panier est vide.');
    }
}
