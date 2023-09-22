<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTinyTable extends Migration
{
    public function up()
    {
        Schema::create('pedidos_tiny', function (Blueprint $table) {
            $table->id();
            $table->string('numero', 50)->nullable();
            $table->string('numero_ecommerce', 50)->nullable();
            $table->date('data_pedido')->nullable();
            $table->date('data_prevista')->nullable();
            $table->date('data_faturamento')->nullable();
            $table->date('data_envio')->nullable();
            $table->date('data_entrega')->nullable();
            $table->integer('id_lista_preco')->nullable();
            $table->string('descricao_lista_preco', 255)->nullable();
            $table->string('cliente_nome', 255)->nullable();
            $table->string('cliente_codigo', 50)->nullable();
            $table->string('cliente_nome_fantasia', 255)->nullable();
            $table->string('cliente_tipo_pessoa', 1)->nullable();
            $table->string('cliente_cpf_cnpj', 18)->nullable();
            $table->string('cliente_ie', 18)->nullable();
            $table->string('cliente_rg', 10)->nullable();
            $table->string('cliente_endereco', 255)->nullable();
            $table->string('cliente_numero', 10)->nullable();
            $table->string('cliente_complemento', 255)->nullable();
            $table->string('cliente_bairro', 255)->nullable();
            $table->string('cliente_cep', 10)->nullable();
            $table->string('cliente_cidade', 255)->nullable();
            $table->string('cliente_uf', 2)->nullable();
            $table->string('cliente_pais', 255)->nullable();
            $table->string('cliente_fone', 50)->nullable();
            $table->string('cliente_email', 255)->nullable();
            $table->string('condicao_pagamento', 30)->nullable();
            $table->string('forma_pagamento', 30)->nullable();
            $table->string('meio_pagamento', 255)->nullable();
            $table->string('nome_transportador', 255)->nullable();
            $table->string('frete_por_conta', 1)->nullable();
            $table->float('valor_frete')->nullable();
            $table->float('valor_desconto')->nullable();
            $table->float('outras_despesas')->nullable();
            $table->float('total_produtos')->nullable();
            $table->float('total_pedido')->nullable();
            $table->string('numero_ordem_compra', 50)->nullable();
            $table->string('deposito', 255)->nullable();
            $table->string('situacao', 50)->nullable();
            $table->string('obs', 100)->nullable();
            $table->string('obs_interna', 100)->nullable();
            $table->integer('id_vendedor')->nullable();
            $table->string('codigo_rastreamento', 50)->nullable();
            $table->string('url_rastreamento', 255)->nullable();
            $table->integer('id_nota_fiscal')->nullable();
            $table->string('id_natureza_operacao', 50)->nullable();
            $table->string('forma_envio', 30)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedidos_tiny');
    }
}
