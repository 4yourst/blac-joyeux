<?php

namespace Tests\Feature;

use App\Models\DeliveryOption;
use App\Models\Order;
use App\Models\Product;
use App\Models\PromoCode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Cahier de recettage — codes promo + bannière (lot 5 §10).
 */
class PromoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); // Inclut le code de démo BLAC30 (−30 %, actif).
    }

    /** La bannière promo s'affiche sur le front quand un code est en cours. */
    public function test_la_banniere_promo_s_affiche(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('BLAC30')
            ->assertSee('se termine dans');
    }

    /** Un code valide applique la réduction au sous-total et l'enregistre sur la commande. */
    public function test_un_code_valide_applique_la_reduction(): void
    {
        $product = Product::where('slug', 'joyau-de-bla-sac-de-bureau')->first(); // 85 000
        $delivery = DeliveryOption::orderBy('price')->first();                     // 2 000

        $this->post(route('cart.add', $product), ['quantity' => 1]);
        $this->post(route('checkout.promo.apply'), ['promo_code' => 'blac30'])
            ->assertRedirect(route('checkout.create'));

        // La réduction apparaît dans le récap de finalisation.
        $this->get(route('checkout.create'))->assertOk()->assertSee('Réduction');

        $this->post(route('checkout.store'), [
            'customer_name' => 'Awa Koné',
            'customer_phone' => '+225 07',
            'customer_address' => 'Cocody',
            'delivery_option_id' => $delivery->id,
        ])->assertRedirect();

        $order = Order::latest()->first();
        $this->assertSame('BLAC30', $order->promo_code);
        $this->assertSame(25500, $order->discount_amount);            // 30 % de 85 000
        $this->assertSame(85000 - 25500 + $delivery->price, $order->total_amount);
    }

    /** Un code invalide est rejeté avec un message d'erreur. */
    public function test_un_code_invalide_est_rejete(): void
    {
        $this->post(route('checkout.promo.apply'), ['promo_code' => 'NEXISTEPAS'])
            ->assertRedirect(route('checkout.create'))
            ->assertSessionHas('error');
    }

    /** Un code expiré n'est pas valide et ne s'applique pas. */
    public function test_un_code_expire_ne_s_applique_pas(): void
    {
        PromoCode::create([
            'code' => 'EXPIRE',
            'discount_percent' => 50,
            'starts_at' => now()->subDays(10),
            'ends_at' => now()->subDay(),
            'is_active' => true,
        ]);

        $this->assertNull(PromoCode::findValid('EXPIRE'));
    }

    /** L'admin peut créer un code promo. */
    public function test_l_admin_peut_creer_un_code_promo(): void
    {
        $this->actingAs(User::where('email', 'admin@blacjoyaux.ci')->first());

        $this->post(route('admin.promos.store'), [
            'code' => 'NOEL25',
            'discount_percent' => 25,
            'starts_at' => now()->format('Y-m-d\TH:i'),
            'ends_at' => now()->addDays(3)->format('Y-m-d\TH:i'),
            'is_active' => 1,
        ])->assertRedirect(route('admin.promos.index'));

        $this->assertDatabaseHas('promo_codes', ['code' => 'NOEL25', 'discount_percent' => 25]);
    }
}
