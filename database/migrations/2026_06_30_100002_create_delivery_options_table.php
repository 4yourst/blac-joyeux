<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Options de livraison paramétrables : zone, délai (1 à 3 jours), tarif (doc §4.1).
     */
    public function up(): void
    {
        Schema::create('delivery_options', function (Blueprint $table) {
            $table->id();
            $table->string('zone');
            $table->unsignedTinyInteger('delay_days'); // Délai 1 à 3 jours
            $table->unsignedInteger('price');           // Tarif en FCFA
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_options');
    }
};
