<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListaUniforme extends Model
{
    protected $table = 'listas_uniforme';
    protected $fillable = ['id_pedido', 'data_criacao', 'sexo', 'arte_aprovada'];
    
    public function produtos()
    {
        return $this->hasMany(ProdutoListaUniforme::class, 'id_lista');
    }
}