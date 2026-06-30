<?php

namespace Tests\Feature;

use App\Models\DeliveryOption;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Cahier de recettage (doc §11) — double voie de conversion (§10.4).
 */
class ConversionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    private function makePendingOrder(): Order
    {
        $product = Product::where('slug', 'joyau-de-bla-sac-de-bureau')->first();
        $delivery = DeliveryOption::orderBy('price')->first();

        $order = Order::create([
            'customer_name' => 'Fatou Diallo',
            'customer_phone' => '+225 0700000002',
            'customer_address' => 'Yopougon, Abidjan',
            'delivery_option_id' => $delivery->id,
            'payment_method_id' => null,
            'total_amount' => $product->price + $delivery->price,
            'conversion_channel' => null,
            'status' => 'pending',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'unit_price' => $product->price,
        ]);

        return $order;
    }

    /** Critère 10 — Voie A : sélection opérateur + paiement simulé + confirmation. */
    public function test_voie_a_paiement_mobile_money_simule(): void
    {
        $order = $this->makePendingOrder();
        $operator = PaymentMethod::where('type', 'mobile_money')->first();

        // L'écran de paiement liste les opérateurs Mobile Money.
        $this->get(route('checkout.payment', $order))
            ->assertOk()
            ->assertSee($operator->name);

        // Le paiement simulé finalise la commande.
        $this->post(route('checkout.payment.store', $order), [
            'payment_method_id' => $operator->id,
        ])->assertRedirect(route('checkout.confirmation', $order));

        $order->refresh();
        $this->assertSame('paid', $order->status);
        $this->assertSame('mobile_money', $order->conversion_channel);
        $this->assertSame($operator->id, $order->payment_method_id);

        $this->get(route('checkout.confirmation', $order))
            ->assertOk()
            ->assertSee('confirmée');
    }

    /** Critère 11 — Voie B : redirection wa.me avec récapitulatif pré-rempli. */
    public function test_voie_b_redirige_vers_whatsapp_avec_recapitulatif(): void
    {
        $order = $this->makePendingOrder();

        $response = $this->post(route('checkout.whatsapp', $order));

        $response->assertRedirect();
        $target = $response->headers->get('Location');

        $this->assertStringContainsString('wa.me/'.config('blacjoyaux.whatsapp_number'), $target);
        $this->assertStringContainsString(rawurlencode('commande #'.$order->id), $target);

        $order->refresh();
        $this->assertSame('whatsapp', $order->status);
        $this->assertSame('whatsapp', $order->conversion_channel);
    }
}
