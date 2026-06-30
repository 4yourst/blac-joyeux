<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Moyens de paiement : Wave, Orange Money, MTN, Moov, espèces.
     * Le champ "type" distingue leur nature (doc §4.1).
     */
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique(); // wave, orange_money, mtn, moov, cash
            $table->enum('type', ['mobile_money', 'cash']); // Nature du moyen de paiement
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
