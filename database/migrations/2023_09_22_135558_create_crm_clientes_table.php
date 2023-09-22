<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmClientesTable extends Migration
{
    public function up()
    {
        Schema::create('crm_clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255);
            $table->string('telefone', 15)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('origem', 50)->nullable();
            $table->integer('id_octa')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('crm_clientes');
    }
}
