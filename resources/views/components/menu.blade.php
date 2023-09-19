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
              
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('bandeira') ? 'active' : '' }}" href="{{ route('bandeira') }}">Bandeiras</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('frete') ? 'active' : '' }}" href="{{ route('frete') }}">Gerar Orçamentos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('pedido') ? 'active' : '' }}" href="{{ route('pedido') }}">Arte Final</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('impressao') ? 'active' : '' }}" href="{{ route('impressao') }}">Impressão</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('confeccao') ? 'active' : '' }}" href="{{ route('confeccao') }}">Controle de Confecções</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('reposicao') ? 'active' : '' }}" href="{{ route('reposicao') }}">Controle de Reposições</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('trello.index') ? 'active' : '' }}" href="{{ route('trello.index') }}">Lista do Trello</a>
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
