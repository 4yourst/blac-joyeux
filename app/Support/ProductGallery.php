<?php

namespace App\Support;

use App\Models\Product;

/**
 * Galerie d'images produit basée sur des dossiers de convention :
 * public/images/products/catalog-01 … catalog-12.
 *
 * Le dossier associé à un produit correspond à sa position dans la page
 * Collection (produits disponibles triés par nom) — Catalogue 1 = 1er produit
 * affiché, etc.
 */
class ProductGallery
{
    /** @var array<int, int>|null Mémorisé le temps de la requête. */
    private static ?array $map = null;

    /**
     * Correspondance [product_id => numéro de dossier] selon l'ordre d'affichage
     * de la page Collection (identique à CollectionController : is_available + tri par nom).
     *
     * @return array<int, int>
     */
    public static function map(): array
    {
        return static::$map ??= Product::where('is_available', true)
            ->orderBy('name')
            ->pluck('id')
            ->mapWithKeys(fn ($id, $index) => [$id => $index + 1])
            ->all();
    }

    /**
     * Chemins des images du dossier, relatifs à public/images (ex. products/catalog-01/1.jpg),
     * triés naturellement.
     *
     * @return array<int, string>
     */
    private static function relativeFiles(int $number): array
    {
        $folder = 'products/catalog-'.sprintf('%02d', $number);
        $directory = public_path('images/'.$folder);

        if (! is_dir($directory)) {
            return [];
        }

        return collect(scandir($directory) ?: [])
            ->reject(fn ($file) => in_array($file, ['.', '..'], true))
            ->filter(fn ($file) => preg_match('/\.(jpe?g|png|webp)$/i', $file))
            ->sort(SORT_NATURAL)
            ->values()
            ->map(fn ($file) => $folder.'/'.$file)
            ->all();
    }

    /**
     * URLs des images de la galerie d'un produit, ou tableau vide si aucun dossier/image.
     *
     * @return array<int, string>
     */
    public static function forProduct(Product $product): array
    {
        $number = static::map()[$product->id] ?? null;

        if ($number === null) {
            return [];
        }

        return array_map(fn ($relative) => asset('images/'.$relative), static::relativeFiles($number));
    }

    /**
     * Chemin de la photo de couverture relatif à public/images
     * (ex. products/catalog-01/1.jpg) — à stocker dans Product::image. Null si aucune.
     */
    public static function coverPath(Product $product): ?string
    {
        $number = static::map()[$product->id] ?? null;

        if ($number === null) {
            return null;
        }

        return static::relativeFiles($number)[0] ?? null;
    }

    /**
     * URL de la photo de couverture (vignette), ou null.
     */
    public static function cover(Product $product): ?string
    {
        $path = static::coverPath($product);

        return $path ? asset('images/'.$path) : null;
    }
}
