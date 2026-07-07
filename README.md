# Blac Joyaux — Prototype e-commerce

Prototype de plateforme e-commerce **mobile-first** pour **Blac Joyaux**, maison de maroquinerie ivoirienne
(collection *Joyau de Bla*). Le parcours est pensé pour le **Social Commerce** : découverte → panier →
**double voie de conversion** (paiement Mobile Money simulé **ou** finalisation sur WhatsApp).

> Projet pédagogique — développé en local. Les visuels fournis sont des **placeholders** (Unsplash, libres d'usage)
> ou les vrais visuels de la marque, en attendant l'intégration définitive de la création.

---

## 🧱 Stack technique

| Couche | Technologie |
|---|---|
| Back-end | **Laravel 12** (PHP 8.2+), architecture MVC |
| Vues | **Blade** |
| Front | **Tailwind CSS v4** (via Vite), JavaScript léger (sans framework) |
| Base de données | **SQLite** (fichier unique, sans serveur) |
| Authentification admin | **Laravel Breeze** (inscription publique désactivée) |

---

## ✅ Prérequis

- **PHP ≥ 8.2** (avec l'extension `pdo_sqlite`)
- **Composer**
- **Node.js** + **npm**
- **Git**

---

## 🚀 Installation

```bash
# 1. Récupérer le code
git clone https://github.com/4yourst/blac-joyeux.git
cd blac-joyeux

# 2. Dépendances PHP et front
composer install
npm install

# 3. Environnement + clé d'application
cp .env.example .env
php artisan key:generate

# 4. Base SQLite
#    (Windows PowerShell : New-Item -ItemType File database/database.sqlite)
touch database/database.sqlite

# 5. Migrations + données de démonstration
php artisan migrate --seed

# 6. Compilation des assets
npm run build        # ou : npm run dev  (rechargement à chaud en développement)

# 7. Lancer le serveur
php artisan serve
```

Le site est accessible sur **http://localhost:8000** (idéalement en vue mobile).

---

## ⚙️ Configuration

Dans `.env` :

```dotenv
APP_LOCALE=fr

# Base de données
DB_CONNECTION=sqlite

# Numéro WhatsApp de la marque — format international SANS le « + »
BLAC_WHATSAPP_NUMBER=2250708771557
```

Le numéro WhatsApp alimente **tout le site** (bouton flottant, footer, page Contact,
voie de conversion WhatsApp, confirmation de commande). Après modification :

```bash
php artisan config:clear
```

---

## 👤 Données de démonstration (après `migrate --seed`)

| Élément | Valeur |
|---|---|
| **Admin** (back-office `/admin`) | `admin@blacjoyaux.ci` / `password` |
| Catalogue | 12 produits (collections *Joyau de Bla* & *Collection DO*) |
| Livraisons | Abidjan (1–2 j) + intérieur (3 j) |
| Paiements | Wave, Orange Money, MTN, Moov, espèces |
| Code promo actif | **`BLAC30`** (−30 %, valable quelques jours) |

---

## 🗺️ Principales fonctionnalités

- **Accueil éditorial** : hero **carrousel** (auto + swipe), réassurance, sélection, héritage, CTA.
- **Page Collection** : listing complet + **recherche** et **filtres** (type, collection).
- **Fiche produit** : **galerie multi-images** (miniatures cliquables), storytelling, **SEO** (JSON-LD).
- **Panier** (session) → **finalisation** (coordonnées, e-mail facultatif, livraison, **code promo**).
- **Double conversion** : Mobile Money **simulé** (aucune transaction réelle) ou **WhatsApp**.
- **Confirmation enrichie** : délai de livraison estimé selon la zone, prochaines étapes.
- **Codes promo** + **bannière compte à rebours** (basée sur la vraie date de fin).
- **Pages** : Notre histoire, Contact (**Google Maps** + formulaire), Livraison & Paiement, FAQ, 404.
- **Back-office** `/admin` : tableau de bord, CRUD produits / livraisons / codes promo, consultation des commandes.

---

## 🖼️ Galerie produit (dossiers d'images)

Chaque produit affiche plusieurs vues, lues automatiquement depuis un dossier de convention :

```
public/images/products/catalog-01/   →  1er produit affiché sur la page Collection
public/images/products/catalog-02/   →  2e produit…
…
public/images/products/catalog-12/   →  12e produit
```

- Le dossier associé suit **l'ordre d'affichage de la page Collection** (produits triés par nom).
- Formats acceptés : `.jpg`, `.jpeg`, `.png`, `.webp` ; nombre d'images libre.
- La **1re image** du dossier sert de vignette (cartes, panier, admin).
- Logique centralisée dans `app/Support/ProductGallery.php`.

---

## 🧪 Tests

```bash
php artisan test
```

Suite de recettage automatisée (parcours vitrine, panier, double conversion, admin, codes promo).
Les tests s'exécutent sur une base **SQLite en mémoire** — la base de développement n'est pas affectée.

---

## 📦 Notes

- `database/database.sqlite` et le dossier `node_modules/` ne sont pas versionnés.
- Les visuels lourds pourront être optimisés (redimension + WebP) pour la mise en production.
- À ce stade (prototype), l'application s'exécute en **local** et n'est pas déployée.
