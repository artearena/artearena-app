<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientesView extends Model
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
        'status_conversa',
        'created_at',
        'data_agendamento',
        'mensagem',
        'contato_bloqueado',
        'contato_qualificado',
        'motivo_perda',
    ];

}
