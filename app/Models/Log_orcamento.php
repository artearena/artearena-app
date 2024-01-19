<?php

// app/Models/Log_orcamento.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log_orcamento extends Model
{
    protected $table = 'logs_orcamento';

    protected $fillable = [
        'id_orcamento',
        'acao',
        'detalhes',
        'data_alteracao',
        'id_user',
    ];

    public $timestamps = false;

    // Relacionamento com o modelo de orçamento
    public function orcamento()
    {
        return $this->belongsTo(Orcamento::class, 'id_orcamento', 'id');
    }

    // Relacionamento com o modelo de usuário
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
