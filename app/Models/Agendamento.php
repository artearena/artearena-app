<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    protected $table = 'agendamento';
    protected $fillable = ['crm_clientes_id', 'horario', 'confirmacao'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'crm_clientes_id');
    }
}