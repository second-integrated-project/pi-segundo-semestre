<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome_produto');
            $table->integer('quantidade');
            $table->integer('quantidade_minima');
            $table->string('categoria');
            $table->timestamp('ultima_reposicao')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->decimal('preco', 8, 2);
            $table->timestamps();
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};
