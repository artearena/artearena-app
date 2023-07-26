<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle($request, Closure $next, $permissionConfig)
    {
        // Verifique se o usuário está autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Obtenha as permissões do usuário a partir do campo 'permissoes' na tabela 'usuarios'
        $userPermissions = Auth::user()->permissoes;

        // Obtenha a configuração de permissão para a rota atual
        $config = config('permissions.' . $permissionConfig);

        // Verifique se o usuário tem permissão para acessar a rota atual
        if (!in_array($config['tela_id'], $userPermissions)) {
            abort(403, 'Acesso não autorizado.');
        }

        return $next($request);
    }
}
