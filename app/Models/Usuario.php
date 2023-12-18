<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios'; // Nome da tabela
    protected $primaryKey = 'id'; // Chave primária

    protected $fillable = ['nome_usuario', 'permissoes', 'email', 'password', 'id_vendedor'];
}