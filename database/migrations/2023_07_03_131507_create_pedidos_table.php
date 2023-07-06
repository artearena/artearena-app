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
            $table->string('produto');
            $table->string('material');
            $table->string('medida_linear');
            $table->text('observacoes')->nullable();
            $table->string('dificuldade')->nullable();
            $table->string('status');
            $table->string('designer')->nullable();
            $table->string('tipo_de_pedido');
            $table->string('checagem_final')->nullable();
            $table->string('tiny')->nullable();
            $table->string('rolo');
            $table->string('outros')->nullable();
            $table->string('etapa');
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
