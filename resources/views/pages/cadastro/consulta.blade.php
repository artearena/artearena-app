    @extends('layout.main')

    @section('title')
    Consulta de Cadastros
    @endsection

    @section('style')
    <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/fh-3.4.0/r-2.5.0/sl-1.7.0/sr-1.3.0/datatables.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($cadastros as $cadastro)
                                @if ($cadastro->atualizar == 0)
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
                                    </tr>
                                @endif
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
            language: {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                },
                "select": {
                    "rows": {
                        "_": "Selecionado %d linhas",
                        "0": "Nenhuma linha selecionada",
                        "1": "Selecionado 1 linha"
                    }
                }
            },
            columns: [
                { data: 'id', title: 'ID' },
                { data: 'tipo_pessoa', title: 'Tipo de Pessoa' },
                { data: 'razao_social', title: 'Razão Social / Nome Completo' },
                { data: 'cnpj_cpf', title: 'CNPJ / CPF' },
                { data: 'ie_rg', title: 'Inscrição Estadual / RG' },
                { data: 'email', title: 'Email' },
                { data: 'cep', title: 'CEP' },
                { data: 'endereco', title: 'Endereço' },
                { data: 'endereco_entrega', title: 'Endereço de Entrega' },
                { data: 'responsavel_entrega', title: 'Responsável Entrega' },
                { data: 'cpf_responsavel_entrega', title: 'CPF Responsável Entrega' }
            ]
        });
        $('#cadastros-table').on('click', '.btn-check', function() {
            var cadastroId = $(this).data('id');
            // Aqui você pode adicionar a lógica para marcar o cadastro com o ID cadastroId
            console.log('Cadastro marcado:', cadastroId);
        });
        $('#btn-atualizar-selecionados').on('click', function() {
            // Obtenha as linhas selecionadas
            var selectedRows = table.rows({ selected: true }).data();
            // Verifique se pelo menos uma linha foi selecionada
            if (selectedRows.length === 0) {
                alert('Selecione pelo menos um cadastro para atualizar.');
                return;
            }
            // Itere sobre as linhas selecionadas
            selectedRows.each(function(data) {
                var id = data.id;
                var tipoPessoa = data.tipo_pessoa;
                var razaoSocial = data.razao_social;
                var cnpjCpf = data.cnpj_cpf;
                var ieRg = data.ie_rg;
                var email = data.email;
                var cep = data.cep;
                var endereco = data.endereco;
                var enderecoEntrega = data.endereco_entrega;
                var responsavelEntrega = data.responsavel_entrega;
                var cpfResponsavelEntrega = data.cpf_responsavel_entrega;
                // Aqui você pode enviar uma solicitação AJAX para atualizar o registro com base nos dados coletados
                $.ajax({
                    url: '/consultarcadastro/' + id, // Substitua pela URL correta do seu servidor
                    method: 'PUT', // Use o método HTTP correto (por exemplo, PUT)
                    data: {
                        tipo_pessoa: tipoPessoa,
                        razao_social: razaoSocial,
                        cnpj_cpf: cnpjCpf,
                        ie_rg: ieRg,
                        email: email,
                        cep: cep,
                        endereco: endereco,
                        endereco_entrega: enderecoEntrega,
                        responsavel_entrega: responsavelEntrega,
                        cpf_responsavel_entrega: cpfResponsavelEntrega,
                        "_token": "{{ csrf_token() }}",
                        // Adicione outros campos conforme necessário
                    },
                    success: function(response) {
                        // Verifique a resposta do servidor para confirmar se a atualização foi bem-sucedida
                        // Atualize a linha na tabela com os novos dados (opcional)
                        table.row({ selected: true }).data(data).draw();
                        alert('Cadastro atualizado com sucesso!');
                    },
                    error: function(error) {
                        console.error('Erro ao atualizar cadastro:', error);
                        alert('Erro ao atualizar cadastro. Verifique o console para mais informações.');
                    }
                });
            });
        });
    });
    </script>
    @endsection