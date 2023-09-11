@extends('layout.main')

@section('content')
<div class="container my-5">
<div class="text-center">
    <i class="bi bi-lock-fill" style="font-size: 6rem;"></i>
</div>
<form method="POST" action="/register">
    @csrf

    <div class="mb-3">
        <label for="nome_usuario" class="form-label">Nome de usuário:</label>
        <input type="text" class="form-control" name="nome_usuario" id="nome_usuario" required>
    </div>
    <div class="mb-3">
        <label for="permissoes" class="form-label">Permissões:</label>
        <select class="form-control" name="permissoes" id="permissoes" required>
            <option value="">Selecione uma permissão</option>
            @foreach($permissoes as $permissao)
                <option value="{{ $permissao->id }}">{{ $permissao->nome }}</option>
            @endforeach
        </select>
    </div>




    <div class="mb-3">
        <label for="email" class="form-label">E-mail:</label>
        <input type="email" class="form-control" name="email" id="email" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Senha:</label>
        <input type="password" class="form-control" name="password" id="password" required>
    </div>

    <button type="submit" class="btn btn-outline-success">Registrar</button>
</form>
</div>


@endsection
