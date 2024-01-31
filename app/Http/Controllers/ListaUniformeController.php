<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\ProdutoPedido;
use App\Models\ProdutoLista;
use App\Models\ListaUniforme;

class ListaUniformeController extends Controller
{
    public function index()
    {
        $listasUniforme = ProdutoPedido::all();
        return view('pages.listaUniformes.index', compact('listasUniforme'));
    }

    public function indexCliente($id)
    {
        // Busca todos os produtos que têm o pedido_id igual ao $id
        $produtos = ProdutoPedido::where('pedido_id', $id)->get();
        return view('pages.listaUniformes.index', compact('produtos'));
    }

    public function consultarListas($id)
    {
        // Busca todas as listas de uniforme associadas ao pedido
        $listasUniforme = ListaUniforme::where('id_pedido', $id)->with('produtos')->get();

        // Retorna os dados como JSON
        return response()->json($listasUniforme);
    }

    public function create()
    {
        return view('listas_uniforme.create');
    }

    public function store(Request $request)
    {
        $lista = ListaUniforme::create($request->all());

        $this->invalidateToken($request->token);

        return redirect()->route('listas_uniforme.index')->with('success', 'Lista de uniforme criada com sucesso!');
    }

    public function edit(ListaUniforme $lista)
    {
        return view('listas_uniforme.edit', compact('lista'));
    }

    public function update(Request $request, ListaUniforme $lista)
    {
        $lista->update($request->all());
        return redirect()->route('listas_uniforme.index')->with('success', 'Lista de uniforme atualizada com sucesso!');
    }

    public function destroy(ListaUniforme $lista)
    {
        $lista->delete();
        return redirect()->route('listas_uniforme.index')->with('success', 'Lista de uniforme excluída com sucesso!');
    }
    public function invalidateToken($token)
    {
        // Remove o token do banco de dados
        DB::table('acesso_temporario')->where('token', $token)->delete();
    }
    public function hasListaUniforme($pedidoId)
    {
        return ListaUniforme::where('pedido_id', $pedidoId)->exists();
    }
    public function verificarAprovacao(Request $request)
    {
        try {
            // Busca todas as listas de uniforme
            $listas = ListaUniforme::all();

            // Array para armazenar o status de aprovação de cada lista
            $aprovacaoListas = [];

            // Verifica o status de aprovação de cada lista
            foreach ($listas as $lista) {
                // Verifica se a lista está aprovada
                $aprovada = $lista->lista_aprovada ? 'Aprovada' : 'Não Aprovada';

                // Adiciona o status de aprovação da lista ao array
                $aprovacaoListas[] = [
                    'id' => $lista->id,
                    'status' => $aprovada
                ];
            }

            // Retorna o array com o status de aprovação de cada lista
            return response()->json($aprovacaoListas);
        } catch (\Exception $e) {
            // Em caso de erro, retorna uma resposta de erro
            return response()->json(['error' => 'Erro ao verificar aprovação das listas'], 500);
        }
    }
    public function aprovarLista(Request $request, $id)
    {
        try {
            $lista = ListaUniforme::findOrFail($id);

            // Inverte o status de aprovação
            $lista->lista_aprovada = $lista->lista_aprovada === 'Aprovada' ? 'Não Aprovada' : 'Aprovada';
            $lista->save();

            return response()->json(['aprovada' => $lista->lista_aprovada], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao aprovar lista'], 500);
        }
    }


}