@extends('layout.main')
@section('title')
    Cadastro pessoal
@endsection
@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cadastro</div>
                <div class="card-body">
                <form method="POST" action="{{ route('cadastro.store', ['token' => request()->token, 'id_cliente_pedido' => request()->id_cliente_pedido]) }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ request()->token }}">
                        <input type="hidden" name="id_cliente_pedido" value="{{ request()->id_cliente_pedido }}">

                         <!-- Seleção de Pessoa Jurídica ou Pessoa Física -->
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="pessoa_juridica" name="tipo_pessoa" value="juridica">
                            <label class="form-check-label" for="pessoa_juridica">Pessoa Jurídica</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="pessoa_fisica" name="tipo_pessoa" value="fisica">
                            <label class="form-check-label" for="pessoa_fisica">Pessoa Física</label>
                        </div>
                        <!-- Pessoa Jurídica -->
                        <div id="pessoa_juridica_campos" style="display: none;">
                            <div class="form-group">
                                <label for="razao_social">Razão Social:</label>
                                <input type="text" name="razao_social" id="razao_social" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="cnpj">CNPJ:</label>
                                <input type="text" name="cnpj" id="cnpj" class="form-control cnpj">
                            </div>
                            <div class="form-group">
                                <label for="ie">Inscrição Estadual:</label>
                                <input type="text" name="ie" id="ie" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email_juridica">Email:</label>
                                <input type="email" name="email_juridica" id="email_juridica" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="cep_juridica">CEP:</label>
                                <input type="text" name="cep_juridica" id="cep_juridica" class="form-control cep" onblur="consultarCep('juridica')">
                            </div>
                            <div class="form-group">
                                <label for="endereco_juridica">Endereço:</label>
                                <input type="text" name="endereco_juridica" id="endereco_juridica" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="numero_juridica">N°:</label>
                                <input type="text" name="numero_juridica" id="numero_juridica" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="bairro_juridica">Bairro:</label>
                                <input type="text" name="bairro_juridica" id="bairro_juridica" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="cidade_juridica">Cidade:</label>
                                <input type="text" name="cidade_juridica" id="cidade_juridica" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="fone_fixo_juridica">Fone fixo:</label>
                                <input type="text" name="fone_fixo_juridica" id="fone_fixo_juridica" class="form-control telefone">
                            </div>
                            <div class="form-group">
                                <label for="cell_juridica">Cell:</label>
                                <input type="text" name="cell_juridica" id="cell_juridica" class="form-control telefone_cel">
                            </div>
                        </div>
                        <!-- Pessoa Física -->
                        <div id="pessoa_fisica_campos" style="display: none;">
                            <div class="form-group">
                                <label for="nome_completo">Nome Completo:</label>
                                <input type="text" name="nome_completo" id="nome_completo" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="rg">RG:</label>
                                <input type="text" name="rg" id="rg" class="form-control rg">
                            </div>
                            <div class="form-group">
                                <label for="cpf">CPF:</label>
                                <input type="text" name="cpf" id="cpf" class="form-control cpf">
                            </div>
                            <div class="form-group">
                                <label for="email_fisica">Email:</label>
                                <input type="email" name="email_fisica" id="email_fisica" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="cep_fisica">CEP:</label>
                                <input type="text" name="cep_fisica" id="cep_fisica" class="form-control cep" onblur="consultarCep('fisica')">
                            </div>
                            <div class="form-group">
                                <label for="endereco_fisica">Endereço:</label>
                                <input type="text" name="endereco_fisica" id="endereco_fisica" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="numero_fisica">N°:</label>
                                <input type="text" name="numero_fisica" id="numero_fisica" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="bairro_fisica">Bairro:</label>
                                <input type="text" name="bairro_fisica" id="bairro_fisica" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="cidade_fisica">Cidade:</label>
                                <input type="text" name="cidade_fisica" id="cidade_fisica" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="fone_fixo_fisica">Fone fixo:</label>
                                <input type="text" name="fone_fixo_fisica" id="fone_fixo_fisica" class="form-control telefone">
                            </div>
                            <div class="form-group">
                                <label for="cell_fisica">Celular:</label>
                                <input type="text" name="cell_fisica" id="cell_fisica" class="form-control telefone_cel">
                            </div>
                        </div>
                        <!-- Checkbox para endereço de cobrança diferente -->
                        <div id="divEnderecoCobranca" class="form-check" style="display: none;">
                            <input type="checkbox" class="form-check-input" id="endereco_cobranca_diferente" name="endereco_cobranca_diferente">
                            <label class="form-check-label" for="endereco_cobranca_diferente">Endereço de Cobrança diferente do Endereço de Entrega</label>
                        </div>
                        <!-- Campos de Endereço de Cobrança -->
                        <div id="endereco_cobranca_campos" style="display: none;">
                            <div class="form-group">
                                <label for="cep_cobranca">CEP:</label>
                                <input type="text" name="cep_cobranca" id="cep_cobranca" class="form-control cep" onblur="consultarCep('cobranca')">
                            </div>
                            <div class="form-group">
                                <label for="endereco_cobranca">Endereço:</label>
                                <input type="text" name="endereco_cobranca" id="endereco_cobranca" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="numero_cobranca">N°:</label>
                                <input type="text" name="numero_cobranca" id="numero_cobranca" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="bairro_cobranca">Bairro:</label>
                                <input type="text" name="bairro_cobranca" id="bairro_cobranca" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="cidade_cobranca">Cidade:</label>
                                <input type="text" name="cidade_cobranca" id="cidade_cobranca" class="form-control">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#endereco_cobranca_campos").hide();

        // Função para exibir ou ocultar campos de acordo com o tipo de pessoa selecionado
        $("input[name='tipo_pessoa']").change(function() {
            var tipoPessoa = $(this).val();

            if (tipoPessoa === 'juridica') {
                $("#endereco_cobranca_campos").hide();

                $("#razao_social").val("");
                $("#cnpj").val("");
                $("#ie").val("");
                $("#email_juridica").val("");
                $("#cep_juridica").val("");
                $("#endereco_juridica").val("");
                $("#numero_juridica").val("");
                $("#bairro_juridica").val("");
                $("#cidade_juridica").val("");
                $("#fone_fixo_juridica").val("");
                $("#cell_juridica").val("");
    
                $("#cep_cobranca").val("");
                $("#endereco_cobranca").val("");
                $("#numero_cobranca").val("");
                $("#bairro_cobranca").val("");
                $("#cidade_cobranca").val("");

                $("#endereco_cobranca_diferente").prop("checked", false);
                $("#pessoa_juridica_campos").show();
                $("#pessoa_fisica_campos").hide();
                $("#divEnderecoCobranca").show();
            } else if (tipoPessoa === 'fisica') {
                $("#endereco_cobranca_campos").hide();

                $("#nome_completo").val("");
                $("#rg").val("");
                $("#cpf").val("");
                $("#email_fisica").val("");
                $("#cep_fisica").val("");
                $("#endereco_fisica").val("");
                $("#numero_fisica").val("");
                $("#bairro_fisica").val("");
                $("#cidade_fisica").val("");
                $("#fone_fixo_fisica").val("");
                $("#cell_fisica").val("");
    
                $("#cep_cobranca").val("");
                $("#endereco_cobranca").val("");
                $("#numero_cobranca").val("");
                $("#bairro_cobranca").val("");
                $("#cidade_cobranca").val("");

                $("#endereco_cobranca_diferente").prop("checked", false);
                $("#pessoa_juridica_campos").hide();
                $("#pessoa_fisica_campos").show();
                $("#divEnderecoCobranca").show();
            }
        });

        // Função para exibir ou ocultar campos de Endereço de Cobrança
        $("#endereco_cobranca_diferente").change(function() {
            if ($(this).is(":checked")) {
                $("#endereco_cobranca_campos").show();
            } else {
                $("#endereco_cobranca_campos").hide();
            }
        });

        // Máscaras de input
        $(".cnpj").mask("00.000.000/0000-00");
        $(".cpf").mask("000.000.000-00");
        $(".cep").mask("00000-000");
        $(".telefone").mask("(00) 0000-0000");
        $(".telefone_cel").mask("(00) 00000-0000");
        $(".rg").mask("00.000.000-0");
    });

    // Função para consultar o CEP e preencher os campos de endereço automaticamente
    function consultarCep(tipo) {
        var cep = $("#cep_" + tipo).val();
        cep = cep.replace(/\D/g, '');

        if (cep.length === 8) {
            $.ajax({
                url: 'https://viacep.com.br/ws/' + cep + '/json/',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.erro) {
                        alert('CEP não encontrado.');
                    } else {
                        $("#endereco_" + tipo).val(data.logradouro);
                        $("#bairro_" + tipo).val(data.bairro);
                        $("#cidade_" + tipo).val(data.localidade);
                    }
                },
                error: function() {
                    alert('Erro ao consultar o CEP.');
                }
            });
        }
    }
</script>
@endsection