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
        Schema::create('tb_produto', function (Blueprint $table) {
            $table->id('id_produto');
            $table->unsignedBigInteger('id_categoria_produto');
            $table->dateTime('data_cadastro');
            $table->string('nome_produto', 150);
            $table->float('valor_produto', 10, 2);
            $table->foreign('id_categoria_produto')
                ->references('id_categoria_planejamento')
                ->on('tb_categoria_produto')
                ->onDelete('cascade');
            $table->index('id_categoria_produto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_produto', function (Blueprint $table) {
            $table->dropForeign(['id_categoria_produto']);
            $table->dropIndex(['id_categoria_produto']);
        });
        Schema::dropIfExists('tb_produto');
    }
};
