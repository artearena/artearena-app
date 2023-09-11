@extends('layout.main')
@section('style')
<style>
.container {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
</style>

@endsection
@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container my-5">
<div class="text-center">
    <i class="bi bi-lock-fill" style="font-size: 6rem;"></i>
</div>

<form method="POST" action="/login">
    @csrf
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Endereço de e-mail</label>
        <input type="email" class="form-control" name="email" id="email" required aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">Nós nunca compartilharemos seu e-mail com ninguém.</div>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Senha</label>
        <input type="password" class="form-control" name="password" id="password" required>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Lembrar de mim</label>
    </div>
    <button type="submit" class="btn btn-outline-success">Entrar</button>
    <a href="">
    Precisa de ajuda?
    </a>
</form>
</div>
@endsection

