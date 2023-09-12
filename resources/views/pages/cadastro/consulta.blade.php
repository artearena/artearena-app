    @extends('layout.main')

    @section('title')
    Consulta de Cadastros
    @endsection

    @section('style')
    <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/fh-3.4.0/r-2.5.0/sl-1.7.0/sr-1.3.0/datatables.min.css" rel="stylesheet">
 
    <style>

        table {
                width: 100%;
            }

        th,
        td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #000000;
            color: white;
        }
        .container{
            max-width: 100%;
        }

    </style>
    @endsection

    <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/fh-3.4.0/r-2.5.0/sr-1.3.0/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>

    @section('content')
    <div class="container">
        <div>
            <div>
                <div>
                    <div>Consulta de Cadastros</div>
                    <div>
                        <table id="cadastros-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tipo de Pessoa</th>
                                <th>Razão Social / Nome Completo</th>
                                <th>CNPJ / CPF</th>
                                <th>Inscrição Estadual / RG</th>
                                <th>Email</th>
                                <th>CEP</th>
                                <th>Endereço</th>
                                <th>Endereço de Entrega</th>
                                <th>Responsável Entrega</th>
                                <th>CPF Responsável Entrega</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($cadastros as $cadastro)
                                <tr>
                                    <td>{{ $cadastro->id }}</td>
                                    <td>{{ $cadastro->tipo_pessoa }}</td>
                                    <td>
                                        @if ($cadastro->tipo_pessoa === 'juridica')
                                            {{ $cadastro->razao_social }}
                                        @else
                                            {{ $cadastro->nome_completo }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($cadastro->tipo_pessoa === 'juridica')
                                            {{ $cadastro->cnpj }}
                                        @else
                                            {{ $cadastro->cpf }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($cadastro->tipo_pessoa === 'juridica')
                                            {{ $cadastro->ie }}
                                        @else
                                            {{ $cadastro->rg }}
                                        @endif
                                    </td>
                                    <td>{{ $cadastro->email }}</td>
                                    <td>{{ $cadastro->cep }}</td>
                                    <td>{{ $cadastro->endereco }}, {{ $cadastro->numero }}, {{ $cadastro->bairro }}, {{ $cadastro->cidade }}</td>
                                    <td>{{ $cadastro->endereco_entrega }}, {{ $cadastro->numero_entrega }}, {{ $cadastro->bairro_entrega }}, {{ $cadastro->cidade_entrega }}</td>
                                    <td>{{ $cadastro->responsavel_entrega }}</td>
                                    <td>{{ $cadastro->cpf_responsavel_entrega }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-check" data-id="{{ $cadastro->id }}">Check</button>
                                    </td>
                                    
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <button id="btn-atualizar-selecionados">Atualizar Selecionados</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
$(document).ready(function() {
    var table = $('#cadastros-table').DataTable({
        fixedheader: true,
        select: true,
        "columnDefs": [
            // Definições das colunas, incluindo a função "render" para formatar a data
            {
                "targets": [0],
                "visible": false
            }
            // Adicione mais definições de colunas conforme necessário
        ],
        columns: [
            { data: 'id', title: 'ID' },
            { data: 'tipo_pessoa', title: 'Tipo de Pessoa' },
            { data: 'razao_social', title: 'Razão Social / Nome Completo' },
            { data: 'cnpj_cpf', title: 'CNPJ / CPF' },
            { data: 'ie_rg', title: 'Inscrição Estadual / RG' },
            { data: 'email', title: 'Email' },
            { data: 'cep', title: 'CEP' },
            { data: 'endereco', title: 'Endereço' },
            { data: 'numero', title: 'Número' },
            { data: 'bairro', title: 'Bairro' },
            { data: 'cidade', title: 'Cidade' },
            { data: 'fone_fixo', title: 'Telefone Fixo' },
            { data: 'cell', title: 'Celular' },
            { data: 'endereco_entrega', title: 'Endereço de Entrega' },
            { data: 'numero_entrega', title: 'Número de Entrega' },
            { data: 'bairro_entrega', title: 'Bairro de Entrega' },
            { data: 'cidade_entrega', title: 'Cidade de Entrega' },
            { data: 'responsavel_entrega', title: 'Responsável Entrega' },
            { data: 'cpf_responsavel_entrega', title: 'CPF Responsável Entrega' },
            { title: 'Ação', render: function(data, type, row) {
                return '<button class="btn btn-primary btn-check" data-id="' + row.id + '">Check</button>';
            }}
        ]
    });

    $('#cadastros-table').on('click', '.btn-check', function() {
        var cadastroId = $(this).data('id');
        // Aqui você pode adicionar a lógica para marcar o cadastro com o ID cadastroId
        console.log('Cadastro marcado:', cadastroId);
    });

    $('#btn-atualizar').on('click', function() {
        // Obtenha a linha selecionada (assumindo que apenas uma linha está selecionada)
        var selectedRow = table.row({ selected: true }).data();
        if (!selectedRow) {
            alert('Selecione um cadastro para atualizar.');
            return;
        }
        // Coleta os dados da linha selecionada
        var id = selectedRow.id;
        var tipoPessoa = selectedRow.tipo_pessoa;
        var razaoSocial = selectedRow.razao_social;
        var cnpjCpf = selectedRow.cnpj_cpf;
        var ieRg = selectedRow.ie_rg;
        var email = selectedRow.email;
        var cep = selectedRow.cep;
        var endereco = selectedRow.endereco;
        var numero = selectedRow.numero;
        var bairro = selectedRow.bairro;
        var cidade = selectedRow.cidade;
        var foneFixo = selectedRow.fone_fixo;
        var cell = selectedRow.cell;
        var enderecoEntrega = selectedRow.endereco_entrega;
        var numeroEntrega = selectedRow.numero_entrega;
        var bairroEntrega = selectedRow.bairro_entrega;
        var cidadeEntrega = selectedRow.cidade_entrega;
        var responsavelEntrega = selectedRow.responsavel_entrega;
        var cpfResponsavelEntrega = selectedRow.cpf_responsavel_entrega;
        // Aqui você pode enviar uma solicitação AJAX para atualizar o registro com base nos dados coletados
        $.ajax({
            url: 'cadastro.update/' + id, // Substitua pela URL correta do seu servidor
            method: 'PUT', // Use o método HTTP correto (por exemplo, PUT)
            data: {
                tipo_pessoa: tipoPessoa,
                razao_social: razaoSocial,
                cnpj_cpf: cnpjCpf,
                ie_rg: ieRg,
                email: email,
                cep: cep,
                endereco: endereco,
                numero: numero,
                bairro: bairro,
                cidade: cidade,
                fone_fixo: foneFixo,
                cell: cell,
                endereco_entrega: enderecoEntrega,
                numero_entrega: numeroEntrega,
                bairro_entrega: bairroEntrega,
                cidade_entrega: cidadeEntrega,
                responsavel_entrega: responsavelEntrega,
                cpf_responsavel_entrega: cpfResponsavelEntrega
                // Adicione outros campos conforme necessário
            },
            success: function(response) {
                // Verifique a resposta do servidor para confirmar se a atualização foi bem-sucedida
                // Atualize a linha na tabela com os novos dados (opcional)
                table.row({ selected: true }).data(selectedRow).draw();
                alert('Cadastro atualizado com sucesso!');
            },
            error: function(error) {
                console.error('Erro ao atualizar cadastro:', error);
                alert('Erro ao atualizar cadastro. Verifique o console para mais informações.');
            }
        });
    });
});
</script>
    @endsection