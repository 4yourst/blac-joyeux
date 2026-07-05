<?php

namespace App\Services;

use App\Models\Product;
use App\Models\PromoCode;
use Illuminate\Support\Collection;

/**
 * Panier stocké en session : [product_id => quantity].
 * L'ajout au panier matérialise une intention d'achat (doc §10.3), sans précommande.
 */
class Cart
{
    private const SESSION_KEY = 'cart';
    private const PROMO_KEY = 'promo_code';

    /**
     * Lignes brutes du panier : [product_id => quantity].
     *
     * @return array<int, int>
     */
    public function raw(): array
    {
        return session()->get(self::SESSION_KEY, []);
    }

    public function add(int $productId, int $quantity = 1): void
    {
        $items = $this->raw();
        $items[$productId] = ($items[$productId] ?? 0) + $quantity;
        $this->persist($items);
    }

    public function update(int $productId, int $quantity): void
    {
        $items = $this->raw();

        if ($quantity <= 0) {
            unset($items[$productId]);
        } else {
            $items[$productId] = $quantity;
        }

        $this->persist($items);
    }

    public function remove(int $productId): void
    {
        $items = $this->raw();
        unset($items[$productId]);
        $this->persist($items);
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
        session()->forget(self::PROMO_KEY);
    }

    /**
     * Applique un code promo s'il est valide. Retourne le code appliqué ou null.
     */
    public function applyPromo(string $code): ?PromoCode
    {
        $promo = PromoCode::findValid($code);

        if ($promo) {
            session()->put(self::PROMO_KEY, $promo->code);
        }

        return $promo;
    }

    public function removePromo(): void
    {
        session()->forget(self::PROMO_KEY);
    }

    /**
     * Code promo actuellement appliqué, revalidé à chaque appel : un code
     * devenu invalide (expiré, désactivé) est automatiquement retiré.
     */
    public function promo(): ?PromoCode
    {
        $code = session()->get(self::PROMO_KEY);

        if (! $code) {
            return null;
        }

        $promo = PromoCode::findValid($code);

        if (! $promo) {
            $this->removePromo();
        }

        return $promo;
    }

    /**
     * Montant de la réduction en FCFA (appliquée au sous-total produits).
     */
    public function discount(): int
    {
        $promo = $this->promo();

        if (! $promo) {
            return 0;
        }

        return (int) round($this->subtotal() * $promo->discount_percent / 100);
    }

    /**
     * Total en FCFA : sous-total − réduction + livraison.
     */
    public function total(int $deliveryPrice = 0): int
    {
        return max(0, $this->subtotal() - $this->discount() + $deliveryPrice);
    }

    /**
     * Lignes détaillées avec produit, quantité et sous-total.
     *
     * @return Collection<int, array{product: Product, quantity: int, line_total: int}>
     */
    public function items(): Collection
    {
        $items = $this->raw();

        if (empty($items)) {
            return collect();
        }

        return Product::whereIn('id', array_keys($items))
            ->get()
            ->map(fn (Product $product) => [
                'product' => $product,
                'quantity' => $items[$product->id],
                'line_total' => $product->price * $items[$product->id],
            ])
            ->values();
    }

    /**
     * Nombre total d'articles (somme des quantités).
     */
    public function count(): int
    {
        return array_sum($this->raw());
    }

    /**
     * Sous-total du panier en FCFA (hors livraison).
     */
    public function subtotal(): int
    {
        return $this->items()->sum('line_total');
    }

    public function isEmpty(): bool
    {
        return empty($this->raw());
    }

    /**
     * @param array<int, int> $items
     */
    private function persist(array $items): void
    {
        session()->put(self::SESSION_KEY, $items);
    }
}
