<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Numéro WhatsApp de la marque
    |--------------------------------------------------------------------------
    |
    | Numéro au format international SANS le « + » (ex. 225XXXXXXXXXX), utilisé
    | pour construire l'URL wa.me de la voie de conversion WhatsApp (doc §3.3).
    |
    */

    'whatsapp_number' => env('BLAC_WHATSAPP_NUMBER', '2250700000000'),

    /*
    |--------------------------------------------------------------------------
    | Types de sacs et collections (valeurs contrôlées)
    |--------------------------------------------------------------------------
    |
    | Source unique de vérité pour le champ « type » et le champ « collection »
    | des produits. Utilisée par le formulaire admin (select), la validation
    | (Rule::in) et les filtres de la page Collection.
    |
    */

    'product_types' => ['bureau', 'cabas', 'pochette', 'soirée', 'tote'],

    'collections' => ['Joyau de Bla', 'Collection DO'],

];
