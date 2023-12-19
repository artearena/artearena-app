<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Permissao; // Importe o modelo de permissão

class CheckPermissionsMiddleware
{
    public function handle($request, Closure $next, $permissaoNome)
    {
        // Verificar se o usuário está autenticado
        if (Auth::check()) {
            // Obter o ID da permissão associada ao usuário
            $permissaoId = Auth::user()->permissoes;

            // Verificar se há uma permissão correspondente ao nome fornecido
            $permissao = Permissao::where('nome', $permissaoNome)
                ->first();

            // Verificar se a permissão existe e se o usuário tem acesso à tela
            if ($permissao && $permissao->id == $permissaoId && in_array($request->route()->getName(), json_decode($permissao->configuracao_permissao))
            ) {
                return $next($request);
            }
        }

        // Usuário não tem permissão - redirecionar ou abortar como necessário
        abort(403, 'Acesso não autorizado.');
    }
}
