<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id('id');
            $table->timestamp('data');
            $table->string('produto')->nullable();
            $table->string('material')->nullable();
            $table->float('medida_linear')->nullable();
            $table->text('observacoes')->nullable();
            $table->string('dificuldade')->nullable();
            $table->string('status')->nullable();
            $table->string('designer')->nullable();
            $table->string('tipo_pedido')->nullable();
            $table->string('checagem_final')->nullable();
            $table->string('tiny')->nullable();
            $table->string('rolo')->nullable();
            $table->string('outros')->nullable();
            $table->string('etapa');
            $table->string('observacao_reposicao')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('created_by')->references('id')->on('usuarios');
            $table->foreign('updated_by')->references('id')->on('usuarios');

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
        Schema::dropIfExists('pedidos');
    }
}
