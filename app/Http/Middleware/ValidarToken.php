<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\DB;
class ValidarToken
{
    public function handle($request, Closure $next)
    {
        $token = $request->query('token');
        $acessoTemporario = DB::table('acesso_temporario')->where('token', $token)->first();
        if (!$acessoTemporario || $acessoTemporario->validade < now()) {
            return redirect()->route('acessonegado');
        }
        return $next($request);
    }
}