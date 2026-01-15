<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('flowers', function (Blueprint $table) {
            // Índice para búsqueda por nombre (LIKE queries)
            $table->index('name');

            // Índice para filtrado y ordenamiento por precio
            $table->index('price');

            // Índice para verificar stock disponible
            $table->index('stock');

            // Índice compuesto para búsquedas que incluyen stock y precio
            $table->index(['stock', 'price']);
        });

        Schema::table('categories', function (Blueprint $table) {
            // Índice para búsqueda por nombre (LIKE queries)
            // slug ya tiene índice único, no necesita otro
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flowers', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['price']);
            $table->dropIndex(['stock']);
            $table->dropIndex(['stock', 'price']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['name']);
        });
    }
};
