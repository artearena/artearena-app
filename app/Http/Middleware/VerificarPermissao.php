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
        //return $next($request);

        $usuario = Auth::user();

        // Verifica se o usuário está autenticado
        if (!$usuario) {
            return $next($request);
        }

        $urlCompleta = $request->fullUrl();
        $urlsExcecoes = [
            'https://arte.app.br',
            'https://arte.app.br/home',
            'https://arte.app.br/logout',
            'https://arte.app.br/login',
            'https://arte.app.br/dev',
            'https://arte.app.br/acessonegado',

        ];
        // Verifica se a $urlCompleta está na lista de URLs exceções
        if (in_array($urlCompleta, $urlsExcecoes)) {
            return $next($request);
        }

        if ($this->verificarPermissaoParaRota($usuario, $urlCompleta)) {
            return $next($request);
        }
        
        abort(403, 'Sem permissão para acessar esta página.');
    }

    private function verificarPermissaoParaRota($usuario, $urlCompleta)
{
    $cargo = $usuario->permissoes; // Certifique-se de ter o relacionamento entre Usuario e Cargo

    if ($cargo && $cargo == 36) {
        return true;
    }

    if ($cargo) {
        // Obtém a lista de telas permitidas para o cargo
        $permissao = Permissao::find($cargo); // Supondo que $cargo seja o ID da permissão

        if ($permissao) {
            // Garante que $permissao->configuracao_permissao seja um array
            $telasPermitidas = is_array($permissao->configuracao_permissao)
                ? $permissao->configuracao_permissao
                : explode(',', str_replace(['[', ']', '"'], '', $permissao->configuracao_permissao));

            // Remove possíveis espaços em branco nos elementos do array
            $telasPermitidas = array_map('trim', $telasPermitidas);

            // Obtém a lista de URLs correspondentes às telas permitidas
            $urlsPermitidas = Tela::whereIn('id', $telasPermitidas)->pluck('url')->toArray();

            // Extrai a parte principal da URL (ignorando os parâmetros)
            $urlPrincipal = strtok($urlCompleta, '?');

            // Verifica se a urlPrincipal está na lista de URLs permitidas
            if ($this->verificarUrlPermitida($urlPrincipal, $urlsPermitidas)) {
                dd([
                    'Permissao' => $permissao,
                    'urlCompleta' => $urlCompleta,
                    'urlsPermitidas' => $urlsPermitidas,
                    'Resultado' => 'Permitido'
                ]);
                return true;
            } else {
                dd([
                    'Permissao' => $permissao,
                    'urlCompleta' => $urlCompleta,
                    'urlsPermitidas' => $urlsPermitidas,
                    'Resultado' => 'Não permitido'
                ]);
                return false;
            }

        }
    }

    return false;
}

// Função auxiliar para verificar se uma URL está na lista de URLs permitidas
private function verificarUrlPermitida($url, $urlsPermitidas)
{
    $urlPrincipal = strtok($url, '/');  // Extrai a parte principal da URL até o primeiro '/'
    $urlPrincipal = rtrim($urlPrincipal, '/');  // Remove a barra final, se houver
    return in_array($urlPrincipal, $urlsPermitidas);
}



    
    
}
