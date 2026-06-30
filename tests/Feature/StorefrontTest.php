<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Cahier de recettage (doc §11) — parcours public / vitrine.
 */
class StorefrontTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /** Critère 1 — Affichage mobile-first (meta viewport présente). */
    public function test_la_page_d_accueil_est_mobile_first(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('width=device-width', false);
    }

    /** Critère 2 — Page d'accueil : capsule + mise en avant du sac de bureau. */
    public function test_la_vitrine_met_en_avant_le_sac_de_bureau_et_la_collection(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Joyau de Bla — Sac de bureau')
            ->assertSee('La collection')
            ->assertSee('Pièce phare');
    }

    /** Critère 3 — Fiche produit : caractéristiques, prix, disponibilité, storytelling. */
    public function test_la_fiche_produit_affiche_les_informations_enrichies(): void
    {
        $product = Product::where('slug', 'joyau-de-bla-sac-de-bureau')->first();

        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee('85 000 FCFA')
            ->assertSee('En stock')
            ->assertSee('Caractéristiques')
            ->assertSee('Cuir pleine fleur')
            ->assertSee("L'histoire du modèle", false);
    }

    /** Critère 4 — Données structurées SEO : Product + Offer sur la fiche. */
    public function test_la_fiche_produit_expose_le_json_ld_product_et_offer(): void
    {
        $product = Product::where('slug', 'joyau-de-bla-sac-de-bureau')->first();

        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee('"@type": "Product"', false)
            ->assertSee('"@type": "Offer"', false)
            ->assertSee('"priceCurrency": "XOF"', false);
    }

    /** Critère 5 + 4 — FAQ affichée + données structurées FAQPage. */
    public function test_la_faq_affiche_les_questions_et_le_json_ld_faqpage(): void
    {
        $this->get(route('faq'))
            ->assertOk()
            ->assertSee('Questions fréquentes')
            ->assertSee('Quels sont les délais de livraison ?')
            ->assertSee('"@type": "FAQPage"', false)
            ->assertSee('"@type": "Question"', false);
    }
}
