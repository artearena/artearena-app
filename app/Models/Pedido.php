<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido',
        'data',
        'produto',
        'material',
        'medida_linear',
        'observacoes',
        'dificuldade',
        'status',
        'designer',
        'tipo_pedido',
        'checagem_final',
        'tiny',
        'situacao',
        'rolo',
        'outros',
        'etapa',
        'created_by',
        'updated_by'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }
}
