<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pedido;

class AcessoTemporarioController extends Controller
{
    public function index(Pedido $pedido)
    {
        // Gera um token de acesso temporário
        $token = uniqid();

        // Salva o token no banco de dados
        DB::table('acesso_temporario')->insert([
            'token' => $token,
            'validade' => now()->addWeek(),
            'pedido_id' => $pedido->id,
        ]);

        // Cria o link de acesso temporário
        $link = route('acesso-temporario.submit', ['token' => $token]);

        // Retorna a view da página de acesso temporário
        return view('acesso-temporario', [
            'link' => $link,
        ]);
    }

    public function submit()
    {
        // Verifica se o token é válido
        $token = request('token');
        $acessoTemporario = DB::table('acesso_temporario')->where('token', $token)->first();

        if ($acessoTemporario && $acessoTemporario->validade >= now()) {
            // Redireciona o usuário para a página /listaUniformes
            return redirect('/listaUniformes');
        } else {
            // Retorna uma mensagem de erro
            return back()->withErrors(['token' => 'Token inválido ou expirado.']);
        }
    }
}