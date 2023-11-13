<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrmClientesView extends Model
{
    protected $table = 'clientes_view';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'nome',
        'telefone',
        'empresa',
        'responsavel_contato',
        'url_octa',
        'status_conversa',
        'created_at',
        'data_agendamento',
        'mensagem',
        'contato_bloqueado',
        'contato_qualificado',
        'motivo_perda',
    ];

}
