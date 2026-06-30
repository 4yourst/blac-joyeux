<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cœur du modèle : chaque commande est une intention d'achat, créée avant
     * la séparation des deux voies de conversion (doc §3.2, §4.1, §4.2).
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Coordonnées de la cliente
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->text('customer_address');

            // Références livraison / paiement
            $table->foreignId('delivery_option_id')->constrained();
            // Nullable : en voie WhatsApp, le paiement se confirme dans la conversation (doc §4.2)
            $table->foreignId('payment_method_id')->nullable()->constrained();

            $table->unsignedInteger('total_amount'); // Montant total en FCFA

            // Voie empruntée, renseignée au choix de la voie (null tant qu'aucune voie n'est choisie)
            $table->enum('conversion_channel', ['mobile_money', 'whatsapp'])->nullable();

            // Statut borné de l'intention d'achat
            $table->enum('status', ['pending', 'paid', 'whatsapp'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
