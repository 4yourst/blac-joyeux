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

    /** La page Collection liste tous les produits disponibles. */
    public function test_la_page_collection_liste_les_produits(): void
    {
        $this->get(route('collection'))
            ->assertOk()
            ->assertSee('La collection')
            ->assertSee('Joyau de Bla — Sac de bureau')
            ->assertSee('Collection DO — Cabas Lagune');
    }

    /** La recherche filtre les produits par nom. */
    public function test_la_recherche_filtre_par_nom(): void
    {
        $this->get(route('collection', ['q' => 'Cabas']))
            ->assertOk()
            ->assertSee('Joyau de Bla — Cabas')
            ->assertSee('Collection DO — Cabas Lagune')
            ->assertDontSee('Joyau de Bla — Pochette');
    }

    /** Le filtre par type ne montre que les produits du type choisi. */
    public function test_le_filtre_par_type(): void
    {
        $this->get(route('collection', ['type' => 'pochette']))
            ->assertOk()
            ->assertSee('Joyau de Bla — Pochette')
            ->assertDontSee('Joyau de Bla — Sac de bureau');
    }

    /** Le filtre par collection et la combinaison type + collection fonctionnent. */
    public function test_les_filtres_type_et_collection_sont_combinables(): void
    {
        $this->get(route('collection', ['collection' => 'Collection DO']))
            ->assertOk()
            ->assertSee('Collection DO — Cabas Lagune')
            ->assertDontSee('Joyau de Bla — Sac de bureau');

        $this->get(route('collection', ['type' => 'bureau', 'collection' => 'Collection DO']))
            ->assertOk()
            ->assertSee('Collection DO — Cartable Exécutif')
            ->assertDontSee('Joyau de Bla — Sac de bureau')
            ->assertDontSee('Collection DO — Cabas Lagune');
    }

    /** Une recherche sans résultat affiche l'état « aucun résultat ». */
    public function test_recherche_sans_resultat(): void
    {
        $this->get(route('collection', ['q' => 'zzznexistepas']))
            ->assertOk()
            ->assertSee('Aucun résultat');
    }

    /** L'accueil ne liste pas tout le catalogue : il renvoie vers la page Collection. */
    public function test_l_accueil_renvoie_vers_la_page_collection(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee(route('collection'), false)
            ->assertSee('Voir toute la collection');
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
