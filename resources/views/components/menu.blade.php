<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="margin-bottom: 15px;">
    <div class="container-fluid">
                @guest
                @if(request()->path() !== 'cadastro')
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="./images/logo.png" alt="" class="logo-img" style="width: 15vh; margin-right: 10px;">
                    </a>
                @endif
                @if(request()->path() == 'cadastro')
                    <img src="./images/logo.png" alt="" class="logo-img" style="width: 15vh; margin-right: 10px;">
                @endif
                
                @else
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="./images/logo.png" alt="" class="logo-img" style="width: 15vh; margin-right: 10px;">
                    </a>
                @endguest
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @guest
                @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="comercialDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Comercial
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="comercialDropdown">
                        <li><a class="dropdown-item" href="{{ route('octa.crm') }}">CRM Octa</a></li>
                        <li><a class="dropdown-item" href="{{ route('bandeira') }}">Bandeira</a></li>
                        <li><a class="dropdown-item" href="{{ route('frete') }}">Gerar Orçamento</a></li>
                        <li><a class="dropdown-item" href="#">Encurtar Link</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="designDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Design
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="designDropdown">
                        <li><a class="dropdown-item" href="{{ route('pedido') }}">Arte Final</a></li>
                        <li><a class="dropdown-item" href="{{ route('tiny.relatorio') }}">Tiny Relatório</a></li>
                        <li><a class="dropdown-item" href="{{ route('trello.index') }}">Mini Trello</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="producaoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Produção
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="producaoDropdown">
                        <li><a class="dropdown-item" href="{{ route('impressao') }}">Impressão</a></li>
                        <li><a class="dropdown-item" href="{{ route('confeccao') }}">Confecção</a></li>
                        <li><a class="dropdown-item" href="{{ route('reposicao') }}">Reposição</a></li>
                    </ul>
                </li>
            </ul>
            @endguest
            <span class="navbar-text" style="margin-right: 40px;">
                @guest
                @if(request()->path() !== 'cadastro')
                    <a href="{{ route('login_page') }}">Login</a>
                @endif
                @else
                
                <div>
                    Bem-vindo, <b class="text-white">{{ auth()->user()->nome_usuario }}</b>
                    <br>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>

                @endguest
            </span>


        </div>
    </div>
</nav>
