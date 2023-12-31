<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
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
        'link_trello',
        'situacao',
        'rolo',
        'outros',
        'etapa',
        'observacao_reposicao',
        'created_by',
        'updated_by',
        'prioridade'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });

        static::created(function ($model) {
            $model->setAutoIncrementStartValue();
        });
    }

    protected function setAutoIncrementStartValue()
    {
        $startValue = 900000;

        $table = $this->getTable();
        $column = $this->getKeyName();

        $query = "ALTER TABLE {$table} AUTO_INCREMENT = {$startValue}";
        DB::statement($query);
    }
}
