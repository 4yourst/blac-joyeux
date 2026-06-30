<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

/**
 * Panier stocké en session : [product_id => quantity].
 * L'ajout au panier matérialise une intention d'achat (doc §10.3), sans précommande.
 */
class Cart
{
    private const SESSION_KEY = 'cart';

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
