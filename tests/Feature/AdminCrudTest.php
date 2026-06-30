<?php

namespace Tests\Feature;

use App\Models\DeliveryOption;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Cahier de recettage (doc §11) — CRUD admin : produits, livraisons, commandes (§10.5).
 */
class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->actingAs(User::where('email', 'admin@blacjoyaux.ci')->first());
    }

    /** Critère 13 — CRUD produits : création, modification, suppression. */
    public function test_crud_produits(): void
    {
        // Création (slug auto-généré)
        $this->post(route('admin.products.store'), [
            'name' => 'Sac Test Recette',
            'price' => 55000,
            'description' => 'Un sac de test.',
            'is_available' => 1,
        ])->assertRedirect(route('admin.products.index'));

        $product = Product::where('name', 'Sac Test Recette')->first();
        $this->assertNotNull($product);
        $this->assertSame('sac-test-recette', $product->slug);

        // Modification
        $this->patch(route('admin.products.update', $product), [
            'name' => 'Sac Test Recette',
            'slug' => $product->slug,
            'price' => 60000,
            'description' => 'Un sac de test mis à jour.',
            'is_available' => 1,
        ])->assertRedirect(route('admin.products.index'));

        $this->assertSame(60000, $product->fresh()->price);

        // Suppression
        $this->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'));

        $this->assertModelMissing($product);
    }

    /** Critère 14 — CRUD livraisons : zones, délais, tarifs. */
    public function test_crud_livraisons(): void
    {
        $this->post(route('admin.delivery-options.store'), [
            'zone' => 'Zone Recette',
            'delay_days' => 2,
            'price' => 4000,
            'is_active' => 1,
        ])->assertRedirect(route('admin.delivery-options.index'));

        $option = DeliveryOption::where('zone', 'Zone Recette')->first();
        $this->assertNotNull($option);

        $this->patch(route('admin.delivery-options.update', $option), [
            'zone' => 'Zone Recette',
            'delay_days' => 3,
            'price' => 4500,
            'is_active' => 1,
        ])->assertRedirect(route('admin.delivery-options.index'));

        $this->assertSame(3, $option->fresh()->delay_days);

        $this->delete(route('admin.delivery-options.destroy', $option))
            ->assertRedirect(route('admin.delivery-options.index'));
        $this->assertModelMissing($option);
    }

    /** Critère 14 — Une option de livraison utilisée par une commande ne peut pas être supprimée. */
    public function test_une_option_de_livraison_utilisee_est_protegee(): void
    {
        $option = DeliveryOption::first();
        Order::create([
            'customer_name' => 'Test',
            'customer_phone' => '+225 00',
            'customer_address' => 'Abidjan',
            'delivery_option_id' => $option->id,
            'total_amount' => 50000,
            'status' => 'pending',
        ]);

        $this->delete(route('admin.delivery-options.destroy', $option))
            ->assertRedirect(route('admin.delivery-options.index'))
            ->assertSessionHas('error');

        $this->assertModelExists($option);
    }

    /** Critère 15 — Consultation des commandes : liste, filtre et détail avec la voie. */
    public function test_consultation_des_commandes(): void
    {
        $product = Product::first();
        $option = DeliveryOption::first();

        $order = Order::create([
            'customer_name' => 'Cliente Recette',
            'customer_phone' => '+225 0102030405',
            'customer_address' => 'Marcory, Abidjan',
            'delivery_option_id' => $option->id,
            'total_amount' => $product->price + $option->price,
            'conversion_channel' => 'whatsapp',
            'status' => 'whatsapp',
        ]);
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'unit_price' => $product->price,
        ]);

        // Liste
        $this->get(route('admin.orders.index'))
            ->assertOk()
            ->assertSee('Cliente Recette')
            ->assertSee('WhatsApp');

        // Filtre par statut
        $this->get(route('admin.orders.index', ['statut' => 'whatsapp']))
            ->assertOk()
            ->assertSee('Cliente Recette');

        $this->get(route('admin.orders.index', ['statut' => 'paid']))
            ->assertOk()
            ->assertDontSee('Cliente Recette');

        // Détail
        $this->get(route('admin.orders.show', $order))
            ->assertOk()
            ->assertSee('Cliente Recette')
            ->assertSee('Marcory, Abidjan')
            ->assertSee('Conversion');
    }
}
