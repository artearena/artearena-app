@extends('layout.main')
@section('title', 'Tabela de Telas')
@section('style')
<style>
    /* Estilos personalizados */
    .dataTable {
        display: block;
        width: 100%;
        margin: 1em 0;
    }
    .dataTable thead,
    .dataTable tbody,
    .dataTable thead tr,
    .dataTable th {
        display: block;
    }
    .dataTable thead {
        float: left;
    }
    .dataTable tbody {
        width: auto;
        position: relative;
        overflow-x: auto;
    }
    .dataTable td,
    .dataTable th {
        padding: .625em;
        line-height: 1.5em;
        border-bottom: 1px dashed #ccc;
        box-sizing: border-box;
        overflow-x: hidden;
        overflow-y: auto;
    }
    .dataTable th {
        text-align: center;
        background: #212529;
        color: white;
        border-bottom: 1px dashed #aaa;
    }
    .dataTable tbody tr {
        display: table-cell;
    }
    .dataTable tbody td {
        display: block;
    }
    .dataTable tr:nth-child(odd) {
        background: rgba(0, 0, 0, 0.07);
    }
    .dataTable .select-container {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .dataTable .select-container select {
        margin: 0;
    }
    @media screen and (min-width: 50em) {
        .dataTable {
            display: table;
        }
        .dataTable thead {
            display: table-header-group;
            float: none;
        }
        .dataTable tbody {
            display: table-row-group;
        }
        .dataTable thead tr,
        .dataTable tbody tr {
            display: table-row;
        }
        .dataTable th,
        .dataTable tbody td {
            display: table-cell;
        }
        .dataTable td,
        .dataTable th {
            width: auto;
        }
        .dataTable .select-container {
            display: table-cell;
        }
        .dataTable .select-container select {
            margin: auto;
        }
        .red-text {
            color: red;
        }
    }

    /* New container styles */
    .container-with-margin {
        margin: 20px; /* Adjust the margin size as needed */
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    // Script personalizado
    $(document).ready(function(){
        function updateField(element) {
            var id = $(element).data('id');
            var field = $(element).data('field');
            var value = $(element).is('input, select, textarea') ? $(element).val() : $(element).text();

            // Verificar se o campo é "permissões" e o valor é "17"
            if (field === "permissoes" && value === "17") {
                swal({
                    title: "ID do vendedor",
                    text: "Por favor, insira o ID do vendedor:",
                    content: "input",
                    button: {
                        text: "OK",
                        closeModal: false,
                    },
                })
                .then((vendedorId) => {
                    if (vendedorId) {
                        // Se o usuário inseriu um ID de vendedor, fazer a solicitação AJAX
                        $.ajax({
                            url: "/usuarios/updateall",
                            type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": id,
                                "field": id_vendedor,
                                "value": vendedorId,
                            },
                            success: function(response){
                                console.log(response);
                                swal("Sucesso!", "Campo atualizado com sucesso!", "success");
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                swal("Erro!", "Ocorreu um erro ao atualizar o campo.", "error");
                            }
                        });
                    } else {
                        // Se o usuário cancelou ou não inseriu um ID de vendedor
                        swal("Operação Cancelada", "Nenhuma atualização foi feita.", "info");
                    }
                });
            } else {
                // Se não for necessário inserir o ID do vendedor, fazer a solicitação AJAX normalmente
                $.ajax({
                    url: "/usuarios/updateall",
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                        "field": field,
                        "value": value
                    },
                    success: function(response){
                        console.log(response);
                        swal("Sucesso!", "Campo atualizado com sucesso!", "success");
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        swal("Erro!", "Ocorreu um erro ao atualizar o campo.", "error");
                    }
                });
            }
        }

        $('.editar-senha').on('click', function(){
            var userId = $(this).data('user-id');

            Swal.fire({
                title: 'Editar Senha',
                input: 'password',
                inputPlaceholder: 'Digite a nova senha',
                showCancelButton: true,
                confirmButtonText: 'Salvar',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true,
                preConfirm: (novaSenha) => {
                    var field = 'password'; // Defina o campo a ser atualizado como 'password'
                    
                    return $.ajax({
                        url: "/usuarios/updateall",
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": userId,
                            "field": field,
                            "value": novaSenha
                        }
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        title: 'Sucesso!',
                        text: 'Senha editada com sucesso!',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: false
                    });
                }
            });
        });

        $('.edit, .edit-select').on('input change', function(){
            updateField(this);
        });

        $('form').on('submit', function(e){
            e.preventDefault();

            var nome_usuario = $('#nome_usuario').val();
            var email = $('#email').val();
            var password = $('#password').val();
            var permissoes = $('#permissoes').val();

            $.ajax({
                url: "{{ route('usuarios.store') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "nome_usuario": nome_usuario,
                    "email": email,
                    "password": password,
                    "permissoes": permissoes
                },
                success: function(response){
                    Swal.fire({
                        title: 'Sucesso!',
                        text: 'Usuário criado com sucesso!',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: false
                    });
                }
            });
        });

        // Adicionando o SweetAlert para a exclusão de usuários
        $('#tabelaUsuarios').on('click', '.btn-danger', function(e){
            e.preventDefault();

            var form = $(this).closest('form');
            var userId = form.data('user-id');

            Swal.fire({
                title: 'Tem certeza de que deseja excluir este usuário?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/usuarios/" + userId,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response){
                            Swal.fire({
                                title: 'Sucesso!',
                                text: 'Usuário excluído com sucesso!',
                                icon: 'success',
                                timer: 3000,
                                showConfirmButton: false
                            });

                            // Remover a linha da tabela
                            form.closest('tr').remove();
                        }
                    });
                }
            });
        });
    });
</script>
@endsection

@section('content')
<div class="app container-with-margin">
    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nome_usuario">Nome do Usuário</label>
            <input type="text" class="form-control" id="nome_usuario" name="nome_usuario" placeholder="Digite o nome do usuário">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Digite o email">
        </div>
        <div class="form-group">
            <label for="password">Senha</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Digite a senha">
        </div>
        <div class="form-group">
            <label for="permissoes">Permissões</label>
            <select class="form-control" id="permissoes" name="permissoes">
                @foreach($permissoes as $permissao)
                    <option value="{{ $permissao->id }}">{{ $permissao->nome }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Criar Usuário</button>
    </form>
    <table id="tabelaUsuarios" class="dataTable">
        <thead>
            <tr>
                <th>Nome do Usuário</th>
                <th>Email</th>
                <th>Permissões</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
            <tr>
                <td contenteditable="true" class="edit" data-id="{{ $usuario->id }}" data-field="nome_usuario">{{ $usuario->nome_usuario }}</td>
                <td contenteditable="true" class="edit" data-id="{{ $usuario->id }}" data-field="email">{{ $usuario->email }}</td>
                <td>
                    <select class="form-control edit-select" data-id="{{ $usuario->id }}" data-field="permissoes">
                        @foreach($permissoes as $permissao)
                            <option value="{{ $permissao->id }}" {{ $usuario->permissoes == $permissao->id ? 'selected' : '' }}>{{ $permissao->nome }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <button class="btn btn-warning editar-senha" data-user-id="{{ $usuario->id }}"><i class="fas fa-key"></i></button>
                    <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display: inline-block;" data-user-id="{{ $usuario->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
