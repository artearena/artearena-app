<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemplateMensagem extends Model
{
    protected $table = 'template_mensagem'; // nome da tabela no banco de dados

    protected $fillable = ['titulo', 'id_template', 'mensagem', 'empresa']; // atributos preenchíveis em massa

    protected $primaryKey = 'id'; // chave primária da tabela

    public $timestamps = false; // desabilita as colunas de timestamps

    public function mensagens()
    {
        return $this->hasMany(Cliente::class);
    }
}