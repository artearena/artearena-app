<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materiais', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao');
            $table->timestamps();
        });

        // Insere os dados
        DB::table('materiais')->insert([
            ['descricao' => 'Cetim'],
            ['descricao' => 'Dryfit'],
            ['descricao' => 'Eva'],
            ['descricao' => 'Neoprene'],
            ['descricao' => 'Tactel'],
            ['descricao' => 'Atoalhado'],
            ['descricao' => 'Soft'],
            ['descricao' => 'Oxford'],
            ['descricao' => 'Alumínio'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materiais');
    }
}
