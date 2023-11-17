<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pedido;

class AcessoTemporarioController extends Controller
{
    public function index(Request $request)
    {
        $pedidoId = $request->input('pedidoId');
        // Gera um token de acesso temporário
        $token = uniqid();

        // Salva o token no banco de dados
        DB::table('acesso_temporario')->insert([
            'token' => $token,
            'validade' => now()->addWeek(),
            'pedido_id' => $pedidoId,
        ]);

        $link = url('https://arte.app.br/cadastro/' . $pedidoId) . '?token=' . $token;

        // Retorna o JSON com o link
        return response()->json([
            'link' => $link,
        ]);
    }

    public function gerarLinkTemporario($id)
    {
        // Gera um token de acesso temporário
        $token = uniqid();
        // Salva o token no banco de dados
        DB::table('acesso_temporario')->insert([
            'token' => $token,
            'validade' => now()->addWeek(),
            'pedido_id' => $id,
        ]);
        $link = url('https://arte.app.br/listaUniformes/' . $id) . '?token=' . $token;
        // Retorna o JSON com o link
        return response()->json([
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
            return view('pages.cadastro.index');
        } else {
            // Retorna uma mensagem de erro
            return back()->withErrors(['token' => 'Token inválido ou expirado.']);
        }
    }

}