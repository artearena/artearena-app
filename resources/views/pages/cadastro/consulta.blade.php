@extends('layout.main')

@section('title')
Consulta de Cadastros
@endsection
<!-- Exemplo de inclusão das dependências -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

@section('content')
<div class="container">
    <div class="flex justify-center">
        <div class="w-full">
            <div class="bg-white shadow-md rounded-lg">
                <div class="p-4 bg-blue-500 text-white font-bold">Consulta de Cadastros</div>
                <div class="p-4">
                    <table id="cadastros-table" class="w-full">
                        <thead>
                            <tr>
                                <th class="py-2">ID</th>
                                <th class="py-2">Tipo de Pessoa</th>
                                <th class="py-2">Razão Social / Nome Completo</th>
                                <th class="py-2">CNPJ / CPF</th>
                                <th class="py-2">Inscrição Estadual / RG</th>
                                <th class="py-2">Email</th>
                                <th class="py-2">CEP</th>
                                <th class="py-2">Endereço</th>
                                <th class="py-2">Endereço de Entrega</th>
                                <th class="py-2">Fone Fixo</th>
                                <th class="py-2">Celular</th>
                                <th class="py-2">Responsável Entrega</th>
                                <th class="py-2">CPF Responsável Entrega</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cadastros as $cadastro)
                                <tr>
                                    <td class="py-2">{{ $cadastro->id }}</td>
                                    <td class="py-2">{{ $cadastro->tipo_pessoa }}</td>
                                    <td class="py-2">
                                        @if ($cadastro->tipo_pessoa === 'juridica')
                                            {{ $cadastro->razao_social }}
                                        @else
                                            {{ $cadastro->nome_completo }}
                                        @endif
                                    </td>
                                    <td class="py-2">
                                        @if ($cadastro->tipo_pessoa === 'juridica')
                                            {{ $cadastro->cnpj }}
                                        @else
                                            {{ $cadastro->cpf }}
                                        @endif
                                    </td>
                                    <td class="py-2">
                                        @if ($cadastro->tipo_pessoa === 'juridica')
                                            {{ $cadastro->ie }}
                                        @else
                                            {{ $cadastro->rg }}
                                        @endif
                                    </td>
                                    <td class="py-2">{{ $cadastro->email }}</td>
                                    <td class="py-2">{{ $cadastro->cep }}</td>
                                    <td class="py-2">{{ $cadastro->endereco }}, {{ $cadastro->numero }}, {{ $cadastro->bairro }}, {{ $cadastro->cidade }}</td>
                                    <td class="py-2">{{ $cadastro->endereco_entrega }}, {{ $cadastro->numero_entrega }}, {{ $cadastro->bairro_entrega }}, {{ $cadastro->cidade_entrega }}</td>
                                    <td class="py-2">{{ $cadastro->fone_fixo }}</td>
                                    <td class="py-2">{{ $cadastro->cell }}</td>
                                    <td class="py-2">{{ $cadastro->responsavel_entrega }}</td>
                                    <td class="py-2">{{ $cadastro->cpf_responsavel_entrega }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#cadastros-table').DataTable({
            ajax: "{{ route('cadastro.data') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'tipo_pessoa', name: 'tipo_pessoa' },
                { data: 'razao_social', name: 'razao_social' },
                { data: 'cnpj', name: 'cnpj' },
                { data: 'ie', name: 'ie' },
                { data: 'email', name: 'email' },
                { data: 'cep', name: 'cep' },
                { data: 'endereco', name: 'endereco' },
                { data: 'numero', name: 'numero' },
                { data: 'bairro', name: 'bairro' },
                { data: 'cidade', name: 'cidade' },
                { data: 'fone_fixo', name: 'fone_fixo' },
                { data: 'cell', name: 'cell' },
                { data: 'endereco_entrega', name: 'endereco_entrega' },
                { data: 'responsavel_entrega', name: 'responsavel_entrega' },
                { data: 'cpf_responsavel_entrega', name: 'cpf_responsavel_entrega' },
            ]
        });
    });
</script>
@endsection