<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log_pedidos extends Model
{
    use HasFactory;

    protected $table = 'logs_pedidos';

    protected $fillable = ['id_pedido', 'descricao', 'tipo', 'data', 'updated_by'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'updated_by');
    }
}   