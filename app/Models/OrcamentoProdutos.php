<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrcamentoProdutos extends Model
{
    use HasFactory;

    protected $table = 'orcamento_produtos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    // Defina os campos que podem ser preenchidos em massa
    protected $fillable = [
        'id_orcamento',
        'nome_produto',
        'valor_unitario',
        'peso_unitario',
        'quantidade',
        'prazo_individual',
    ];

    // Relacionamento com a tabela Orcamentos
    public function orcamento()
    {
        return $this->belongsTo(Orcamentos::class, 'id_orcamento');
    }
}