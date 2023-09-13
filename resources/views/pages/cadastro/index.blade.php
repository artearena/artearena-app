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
                    <form method="POST" action="{{ route('cadastro.store') }}">
                        @csrf

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
                                <input type="text" name="cep_juridica" id="cep_juridica" class="form-control cep">
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
                                <input type="text" name="cell_juridica" id="cell_juridica" class="form-control telefone">
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
                                <input type="text" name="cep_fisica" id="cep_fisica" class="form-control cep">
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
                                <input type="text" name="cell_fisica" id="cell_fisica" class="form-control telefone">
                            </div>
                        </div>

                        <!-- Checkbox para endereço de cobrança diferente -->
                        <div id="divEnderecoCobranca" class="form-check" style="display: none;">
                            <input type="checkbox" class="form-check-input" id="endereco_cobranca_diferente" name="endereco_cobranca_diferente">
                            <label class="form-check-label" for="endereco_cobranca_diferente">Endereço de Cobrança diferente do Endereço de Entrega</label>
                        </div>

                        <!-- Endereço de Entrega -->
                        <div id="endereco_entrega_campos" style="display: none;">
                            <div class="form-group">
                                <label for="cep_entrega">CEP:</label>
                                <input type="text" name="cep_entrega" id="cep_entrega" class="form-control cep">
                            </div>
                            <div class="form-group">
                                <label for="endereco_entrega">Endereço de Entrega:</label>
                                <input type="text" name="endereco_entrega" id="endereco_entrega" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="numero_entrega">N°:</label>
                                <input type="text" name="numero_entrega" id="numero_entrega" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="bairro_entrega">Bairro:</label>
                                <input type="text" name="bairro_entrega" id="bairro_entrega" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="cidade_entrega">Cidade:</label>
                                <input type="text" name="cidade_entrega" id="cidade_entrega" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="responsavel_entrega">Nome do Responsável:</label>
                                <input type="text" name="responsavel_entrega" id="responsavel_entrega" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="cpf_responsavel_entrega">CPF do Responsável:</label>
                                <input type="text" name="cpf_responsavel_entrega" id="cpf_responsavel_entrega" class="form-control">
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pessoaJuridica = document.getElementById('pessoa_juridica');
        const pessoaFisica = document.getElementById('pessoa_fisica');
        const enderecoCobrancaDiferente = document.getElementById('endereco_cobranca_diferente');
        const enderecoEntregaCampos = document.getElementById('endereco_entrega_campos');

        pessoaJuridica.addEventListener('change', function () {
            if (pessoaJuridica.checked) {
                document.getElementById('pessoa_juridica_campos').style.display = 'block';
                document.getElementById('pessoa_fisica_campos').style.display = 'none';
                divEnderecoCobranca.style.display = 'block';
            }
        });

        pessoaFisica.addEventListener('change', function () {
            if (pessoaFisica.checked) {
                document.getElementById('pessoa_fisica_campos').style.display = 'block';
                document.getElementById('pessoa_juridica_campos').style.display = 'none';
                divEnderecoCobranca.style.display = 'block';
            }
        });

        enderecoCobrancaDiferente.addEventListener('change', function () {
            if (enderecoCobrancaDiferente.checked) {
                enderecoEntregaCampos.style.display = 'block';
            } else {
                enderecoEntregaCampos.style.display = 'none';
            }
        });
        pessoaJuridica.addEventListener('change', function () {
        if (pessoaJuridica.checked) {
            document.getElementById('pessoa_juridica_campos').style.display = 'block';
            document.getElementById('pessoa_fisica_campos').style.display = 'none';
            limparCampos();
        }
        });

        pessoaFisica.addEventListener('change', function () {
            if (pessoaFisica.checked) {
                document.getElementById('pessoa_fisica_campos').style.display = 'block';
                document.getElementById('pessoa_juridica_campos').style.display = 'none';
                limparCampos();
            }
        });

        // Função para limpar todos os campos do formulário
        function limparCampos() {
            // Limpar campos de Pessoa Jurídica
            $('#razao_social').val('');
            $('#cnpj').val('');
            $('#ie').val('');
            $('#email_juridica').val('');
            $('#cep_juridica').val('');
            $('#endereco_juridica').val('');
            $('#numero_juridica').val('');
            $('#bairro_juridica').val('');
            $('#cidade_juridica').val('');
            $('#fone_fixo_juridica').val('');
            $('#cell_juridica').val('');

            // Limpar campos de Pessoa Física
            $('#nome_completo').val('');
            $('#rg').val('');
            $('#cpf').val('');
            $('#email_fisica').val('');
            $('#cep_fisica').val('');
            $('#endereco_fisica').val('');
            $('#numero_fisica').val('');
            $('#bairro_fisica').val('');
            $('#cidade_fisica').val('');
            $('#fone_fixo_fisica').val('');
            $('#cell_fisica').val('');

            // Limpar campos de Endereço de Entrega
            $('#cep_entrega').val('');
            $('#numero_entrega').val('');
            $('#bairro_entrega').val('');
            $('#cidade_entrega').val('');
            $('#endereco_entrega').val('');
            $('#responsavel_entrega').val('');
            $('#cpf_responsavel_entrega').val('');

            // Desmarcar checkbox de endereço de cobrança diferente
            $('#endereco_cobranca_diferente').prop('checked', false);

            // Esconder campos de Endereço de Entrega se necessário
            if (!enderecoCobrancaDiferente.checked) {
                enderecoEntregaCampos.style.display = 'none';
            }
        }
    });
    $(document).ready(function () {
        
        // Máscara para CNPJ
        $('#cnpj').mask('00.000.000/0000-00');

        // Máscara para CPF
        $('#cpf').mask('000.000.000-00');
        $('#rg').mask('00.000.000-0');
        $('#cpf_responsavel_entrega').mask('000.000.000-00');


        // Máscara para CEP (Jurídica)
        $('#cep_juridica').mask('00000-000');

        // Máscara para CEP (Física)
        $('#cep_fisica').mask('00000-000');

        $('#cep_entrega').mask('00000-000');
        // Máscara para telefone fixo
        $('#fone_fixo_juridica').mask('(00) 0000-0000');
        $('#fone_fixo_fisica').mask('(00) 0000-0000');

        // Máscara para celular
        $('#cell_juridica').mask('(00) 00000-0000');
        $('#cell_fisica').mask('(00) 00000-0000');
    });
</script>
@endsection