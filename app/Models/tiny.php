<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiny extends Model
{
    use HasFactory;

    protected $table = 'pedidos_tiny';

    protected $fillable = [
        'numero',
        'numero_ecommerce',
        'data_pedido',
        'data_prevista',
        'data_faturamento',
        'data_envio',
        'data_entrega',
        'id_lista_preco',
        'descricao_lista_preco',
        'cliente_nome',
        'cliente_codigo',
        'cliente_nome_fantasia',
        'cliente_tipo_pessoa',
        'cliente_cpf_cnpj',
        'cliente_ie',
        'cliente_rg',
        'cliente_endereco',
        'cliente_numero',
        'cliente_complemento',
        'cliente_bairro',
        'cliente_cep',
        'cliente_cidade',
        'cliente_uf',
        'cliente_pais',
        'cliente_fone',
        'cliente_email',
        'condicao_pagamento',
        'forma_pagamento',
        'meio_pagamento',
        'nome_transportador',
        'frete_por_conta',
        'valor_frete',
        'valor_desconto',
        'outras_despesas',
        'total_produtos',
        'total_pedido',
        'numero_ordem_compra',
        'deposito',
        'situacao',
        'obs',
        'obs_interna',
        'id_vendedor',
        'codigo_rastreamento',
        'url_rastreamento',
        'id_nota_fiscal',
        'id_natureza_operacao',
        'forma_envio',
    ];

}
