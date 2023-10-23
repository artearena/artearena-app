<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutoListaUniforme extends Model
{
    protected $table = 'produtos_lista_uniforme';
    protected $fillable = ['nome', 'numero', 'tamanho', 'id_lista'];
    
    public function listaUniforme()
    {
        return $this->belongsTo(ListaUniforme::class, 'id_lista');
    }
}