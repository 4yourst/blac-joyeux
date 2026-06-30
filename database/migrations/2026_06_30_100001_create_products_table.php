<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Catalogue des sacs Blac Joyaux (doc §4.1).
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedInteger('price'); // Prix en FCFA, sans décimales (doc §4.2)
            $table->text('description');
            $table->text('story')->nullable();      // Storytelling / héritage (doc §10.2)
            $table->string('dimensions')->nullable();
            $table->string('material')->nullable();  // Matières
            $table->string('care')->nullable();      // Entretien
            $table->string('image')->nullable();     // Visuel
            $table->boolean('is_available')->default(true); // Statut de disponibilité
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
