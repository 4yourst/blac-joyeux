<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ajoute le type de sac et la collection au catalogue (socle des filtres, lot 5 §1).
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('type')->nullable()->after('slug');
            $table->string('collection')->nullable()->after('type');
        });

        // Backfill des produits existants (aucune donnée cassée).
        $types = [
            'joyau-de-bla-sac-de-bureau' => 'bureau',
            'joyau-de-bla-cabas' => 'cabas',
            'joyau-de-bla-pochette' => 'pochette',
        ];

        foreach ($types as $slug => $type) {
            DB::table('products')->where('slug', $slug)->update(['type' => $type]);
        }

        // Toute la collection existante appartient à « Joyau de Bla ».
        DB::table('products')->whereNull('collection')->update(['collection' => 'Joyau de Bla']);
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['type', 'collection']);
        });
    }
};
