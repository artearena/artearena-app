<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome_usuario');
            $table->string('permissoes')->default('0');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        DB::table('usuarios')->insert([
            ['nome_usuario' => 'Gabriel Lima','permissoes' => '2    ' ,'email' => 'gabriel.lima20@gmail.com', 'password' => '$2y$10$HOD7ouVs.qgzUSg7tpaDhOZngWWIA.yoi7rH/2UtrEPnshB8UxR5q'],
        ]);
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
