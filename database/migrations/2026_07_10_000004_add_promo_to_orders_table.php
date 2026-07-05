<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Trace du code promo appliqué et du montant remisé sur la commande (lot 5 §10).
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('promo_code')->nullable()->after('total_amount');
            $table->unsignedInteger('discount_amount')->default(0)->after('promo_code');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['promo_code', 'discount_amount']);
        });
    }
};
