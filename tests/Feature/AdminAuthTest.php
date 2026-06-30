<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Cahier de recettage (doc §11) — authentification de l'espace d'administration (§5.1).
 */
class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /** Critère 12 — Les routes /admin sont bloquées pour les visiteurs non authentifiés. */
    public function test_l_admin_est_protege_pour_les_visiteurs(): void
    {
        $this->get('/admin')->assertRedirect(route('login'));
        $this->get(route('admin.products.index'))->assertRedirect(route('login'));
        $this->get(route('admin.orders.index'))->assertRedirect(route('login'));
    }

    /** Critère 12 — L'inscription publique est désactivée (doc §5.1). */
    public function test_l_inscription_publique_est_desactivee(): void
    {
        $this->get('/register')->assertNotFound();
        $this->post('/register', [])->assertNotFound();
    }

    /** Critère 12 — Connexion sécurisée avec des identifiants valides. */
    public function test_un_administrateur_peut_se_connecter(): void
    {
        $this->post(route('login'), [
            'email' => 'admin@blacjoyaux.ci',
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticated();

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Tableau de bord');
    }

    /** Critère 12 — Des identifiants invalides sont rejetés. */
    public function test_des_identifiants_invalides_sont_rejetes(): void
    {
        $this->post(route('login'), [
            'email' => 'admin@blacjoyaux.ci',
            'password' => 'mauvais-mot-de-passe',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
