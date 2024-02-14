@extends('layout.main')
@section('title')
    Cadastro pessoal
@endsection
@section('style')
<style>
    .cnpj-input-size {
        width: 250px;
    }
    .ie {
        width: 250px;
    }
    .razao_social{
        width: 800px;
    }

</style>
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

                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="pessoa_juridica" name="tipo_pessoa" value="juridica">
                            <label class="form-check-label" for="pessoa_juridica">Pessoa Jurídica</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="pessoa_fisica" name="tipo_pessoa" value="fisica">
                            <label class="form-check-label" for="pessoa_fisica">Pessoa Física</label>
                        </div>

                        
                        <!-- Pessoa Jurídica -->
                        <div id="pessoa_juridica_campos" style="display: none;">
                            <!-- Container: Dados da Empresa -->
                            <div id="dados_empresa_container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="razao_social">Razão Social:</label>
                                            <input type="text" name="razao_social" id="razao_social" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-md-6">
                                    <label for="cnpj">CNPJ:</label>
                                    <input type="text" name="cnpj" id="cnpj" class="form-control cnpj cnpj-input-size">
                                </div>
                                <div class="col-md-6">
                                    <label for="ie">Inscrição Estadual:</label>
                                    <input type="text" name="ie" id="ie" class="form-control ie">
                                </div>
                                </div>

                            </div>
                            <hr>
                            <!-- Container: Endereço -->
                            <div id="endereco_container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cep_juridica">CEP:</label>
                                            <input type="text" name="cep_juridica" id="cep_juridica" class="form-control cep" onblur="consultarCep('juridica')">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="endereco_juridica">Endereço:</label>
                                            <input type="text" name="endereco_juridica" id="endereco_juridica" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="numero_juridica">N°:</label>
                                            <input type="text" name="numero_juridica" id="numero_juridica" class="form-control">
                                        </div>
                                    <div>
                                </div>
                                <div class="row">
                                        <div class="form-group">
                                            <label for="bairro_juridica">Bairro:</label>
                                            <input type="text" name="bairro_juridica" id="bairro_juridica" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="cidade_juridica">Cidade:</label>
                                            <input type="text" name="cidade_juridica" id="cidade_juridica" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="uf_juridica">UF:</label>
                                            <select name="uf_juridica" id="uf_juridica" class="form-control">
                                                <option value="">Selecione a UF</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Container: Contato -->
                            <div id="contato_container">
                                <div class="form-group">
                                    <label for="cell_juridica">Cell:</label>
                                    <input type="text" name="cell_juridica" id="cell_juridica" class="form-control telefone_cel">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email_juridica">Email:</label>
                                        <input type="email" name="email_juridica" id="email_juridica" class="form-control">
                                    </div>
                                </div>
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
                                <label for="uf_fisica">UF:</label>
                                <select name="uf_fisica" id="uf_fisica" class="form-control">
                                    <option value="">Selecione a UF</option>
                                </select>
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
                            <div class="form-group">
                                <label for="uf_cobranca">UF:</label>
                                <input type="text" name="uf_cobranca" id="uf_cobranca" class="form-control">
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
                $("#uf_juridica").val("");

                $("#fone_fixo_juridica").val("");
                $("#cell_juridica").val("");
    
                $("#cep_cobranca").val("");
                $("#endereco_cobranca").val("");
                $("#numero_cobranca").val("");
                $("#bairro_cobranca").val("");
                $("#cidade_cobranca").val("");
                $("#uf_cobranca").val("");


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
                $("#uf_fisica").val("");

                $("#fone_fixo_fisica").val("");
                $("#cell_fisica").val("");
    
                $("#cep_cobranca").val("");
                $("#endereco_cobranca").val("");
                $("#numero_cobranca").val("");
                $("#bairro_cobranca").val("");
                $("#cidade_cobranca").val("");
                $("#uf_cobranca").val("");

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
        $(".ie").mask("000.000.000.000");
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
    $(document).ready(function() {
        // Função para verificar se pelo menos um dos campos está preenchido
        function validarFormulario() {
            var nomeCompleto = $("#nome_completo").val();
            var razaoSocial = $("#razao_social").val();
            var cpf = $("#cpf").val();
            var cnpj = $("#cnpj").val();
            
            // Verifica se pelo menos um dos campos está preenchido
            if ((!nomeCompleto && !razaoSocial) || (!cpf && !cnpj)) {
                alert("Por favor, preencha pelo menos um dos campos: Nome Completo ou Razão Social, e CPF ou CNPJ.");
                return false; // Impede a submissão do formulário
            }
            return true;
        }
        
        // Intercepta a submissão do formulário e executa a validação
        $("form").submit(function() {
            return validarFormulario();
        });
    });
    $(document).ready(function() {
        var estados = [
            { sigla: '', nome: 'Selecione a UF' },
            { sigla: 'AC', nome: 'Acre' },
            { sigla: 'AL', nome: 'Alagoas' },
            { sigla: 'AP', nome: 'Amapá' },
            { sigla: 'AM', nome: 'Amazonas' },
            { sigla: 'BA', nome: 'Bahia' },
            { sigla: 'CE', nome: 'Ceará' },
            { sigla: 'DF', nome: 'Distrito Federal' },
            { sigla: 'ES', nome: 'Espírito Santo' },
            { sigla: 'GO', nome: 'Goiás' },
            { sigla: 'MA', nome: 'Maranhão' },
            { sigla: 'MT', nome: 'Mato Grosso' },
            { sigla: 'MS', nome: 'Mato Grosso do Sul' },
            { sigla: 'MG', nome: 'Minas Gerais' },
            { sigla: 'PA', nome: 'Pará' },
            { sigla: 'PB', nome: 'Paraíba' },
            { sigla: 'PR', nome: 'Paraná' },
            { sigla: 'PE', nome: 'Pernambuco' },
            { sigla: 'PI', nome: 'Piauí' },
            { sigla: 'RJ', nome: 'Rio de Janeiro' },
            { sigla: 'RN', nome: 'Rio Grande do Norte' },
            { sigla: 'RS', nome: 'Rio Grande do Sul' },
            { sigla: 'RO', nome: 'Rondônia' },
            { sigla: 'RR', nome: 'Roraima' },
            { sigla: 'SC', nome: 'Santa Catarina' },
            { sigla: 'SP', nome: 'São Paulo' },
            { sigla: 'SE', nome: 'Sergipe' },
            { sigla: 'TO', nome: 'Tocantins' }
        ];

        // Popula os campos de UF
        estados.forEach(function(estado) {
            $('#uf_juridica').append($('<option>', {
                value: estado.sigla,
                text: estado.sigla
            }));

            $('#uf_fisica').append($('<option>', {
                value: estado.sigla,
                text: estado.sigla
            }));
        });
    });
</script>
@endsection