<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamentos extends Model
{
    use HasFactory;

    protected $table = 'orcamento';
    protected $primaryKey = 'id';
    public $timestamps = true;

    // Defina os campos que podem ser preenchidos em massa
    protected $fillable = [
        'id',
        'detalhes_orcamento',
        'cep_frete',
        'endereco_frete',
        'nome_transportadora',
        'valor_frete',
        'prazo_entrega',
        'data_prevista',
        'logo_frete',
    ];

    // Relacionamento com a tabela Orcamento_Produtos
    public function produtos()
    {
        return $this->hasMany(OrcamentoProdutos::class, 'id_orcamento');
    }
}