<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class VerificarPermissao
{
    public function handle(Request $request, Closure $next, ...$rotas)
    {
        $usuario = Auth::user();
        // Obtém o nome da rota atual
        $rotaAtual = $request->route();

        // Exibe informações sobre a rota para depuração
        dd($rotaAtual + 'teste');
        foreach ($rotas as $rota) {
            if ($this->verificarPermissaoParaRota($usuario, $rota)) {
                return $next($request);
            }
        }
        return $next($request);

        //abort(403, 'Sem permissão para acessar esta página.');
    }

    private function verificarPermissaoParaRota($usuario, $rota)
    {
        $cargo = $usuario->permissoes; // Certifique-se de ter o relacionamento entre Usuario e Cargo

        if ($cargo && in_array($rota, explode(',', $cargo->configuracao_permissao))) {
            return true;
        }

        return true;
    }
}
