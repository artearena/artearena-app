<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListaUniforme extends Model
{
    protected $table = 'listas_uniforme';

    protected $fillable = [
        'id_pedido',
        'data_criacao',
        'lista_aprovada',
    ];

    // Defina os relacionamentos conforme necessário
    public function produtos()
    {
        return $this->hasMany(ProdutoLista::class, 'id_lista');
    }
}
