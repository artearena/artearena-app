<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="
margin-bottom: 15px;
">
    <div class="container-fluid">
        <img src="./images/logo.png" alt="" style="
        width: 30vh;
        margin-right: 30px;
        margin-left: 10px;
    ">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            @guest
            
            @else
            <li class="nav-item">
                <a class="nav-link {{ request()->is('home') ? 'active' : '' }}" href="{{ route('home') }}">Recursos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('bandeira') ? 'active' : '' }}" href="{{ route('bandeira') }}">bandeira</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled {{ request()->is('2') ? 'active' : '' }}" href="{{ route('bandeira') }}">----</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled {{ request()->is('bandeiraa') ? 'active' : '' }}" href="{{ route('bandeira') }}">Minha Conta</a>
            </li>
            <li class="nav-item dropdown">
                @if(auth()->check() && auth()->user()->permissoes === 'administrador')
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Administração
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Gerenciar Contas</a></li>
                        <li><a class="dropdown-item disabled" href="#">---</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Abrir Chamado</a></li>
                    </ul>
                @endif
            </li>
            @endguest

        </ul>

        <span class="navbar-text" style="margin-right: 20px;">
            @guest
                <a href="{{ route('login_page') }}">Login</a>
            @else
            Bem-vindo, <b class="text-white">{{ auth()->user()->nome_usuario }}</b>
            <br>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endguest
        </span>

      </div>
    </div>
  </nav>
