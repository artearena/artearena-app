<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->date('DATA_CRIACAO')->nullable();
            $table->string('NOME')->nullable();
            $table->string('CODIGO')->nullable();
            $table->decimal('PRECO', 10, 2)->nullable();
            $table->decimal('PRECO_PROMOCIONAL', 10, 2)->nullable();
            $table->string('UNIDADE')->nullable();
            $table->string('GTIN')->nullable();
            $table->string('TIPOVARIACAO')->nullable();
            $table->string('LOCALIZACAO')->nullable();
            $table->decimal('PRECO_CUSTO', 10, 2)->nullable();
            $table->decimal('PRECO_CUSTO_MEDIO', 10, 2)->nullable();
            $table->string('SITUACAO')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}
