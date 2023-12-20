<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Permissao;
use App\Models\Tela;

class VerificarPermissao
{
    public function handle(Request $request, Closure $next)
    {
        $usuario = Auth::user();
        dd($usuario);   

        // Verifica se o usuário está autenticado
        if ($usuario) {
            $urlCompleta = $request->fullUrl();
            $urlsExcecoes = [
                'https://arte.app.br',
                'https://arte.app.br/home',
                'https://arte.app.br/logout',
                'https://arte.app.br/login',
            ];

            // Verifica se a $urlCompleta está na lista de URLs exceções
            if (in_array($urlCompleta, $urlsExcecoes)) {
                return $next($request);
            }

            if ($this->verificarPermissaoParaRota($usuario, $urlCompleta)) {
                return $next($request);
            }
        }
        return $next($request);

        //abort(403, 'Sem permissão para acessar esta página.');
    }
    private function verificarPermissaoParaRota($usuario, $urlCompleta)
    {
        $cargo = $usuario->permissoes; // Certifique-se de ter o relacionamento entre Usuario e Cargo
    
        if ($cargo) {
            // Obtém a lista de telas permitidas para o cargo
            $permissao = Permissao::find($cargo); // Supondo que $cargo seja o ID da permissão
    
            if ($permissao) {
                $telasPermitidas = explode(',', $permissao->configuracao_permissao);
                
                // Obtém a lista de URLs correspondentes às telas permitidas
                $urlsPermitidas = Tela::whereIn('id', $telasPermitidas)->pluck('url')->toArray();
    
                // Verifica se a urlCompleta está na lista de URLs permitidas
                if (in_array($urlCompleta, $urlsPermitidas)) {
                    return true;
                }
            }
        }
    
        return false;
    }
    
    
}
