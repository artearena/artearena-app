<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdutoLista;
use App\Models\ListaUniforme;

class ProdutoListaController extends Controller
{
    public function index()
    {
        $produtos = ProdutoLista::all();
        return view('produtos_lista.index', compact('produtos'));
    }

    public function create()
    {
        return view('produtos_lista.create');
    }

    public function store(Request $request)
    {
        ProdutoLista::create($request->all());
        return redirect()->route('produtos_lista.index')->with('success', 'Produto da lista criado com sucesso!');
    }

    public function show($id)
    {
        $produto = ProdutoLista::find($id);
        return view('produtos_lista.show', compact('produto'));
    }

    public function edit($id)
    {
        $produto = ProdutoLista::find($id);
        return view('produtos_lista.edit', compact('produto'));
    }

    public function update(Request $request, $id)
    {
        ProdutoLista::find($id)->update($request->all());
        return redirect()->route('produtos_lista.index')->with('success', 'Produto da lista atualizado com sucesso!');
    }

    public function destroy($id)
    {
        ProdutoLista::find($id)->delete();
        return redirect()->route('produtos_lista.index')->with('success', 'Produto da lista excluído com sucesso!');
    }

    public function gravarLista(Request $request)
    {
        $listaUniformes = $request->input('listaUniformes');

        try {
            $produtosSalvos = [];

            // Obtenha o id_pedido do array $listaUniformes
            $pedido_id = $listaUniformes['pedido_id'][0];

            // Crie a lista uniforme com o id_pedido
            $novaLista = ListaUniforme::create([
                'id_pedido' => $pedido_id,
                'data_criacao' => now(),
            ]);

            foreach ($listaUniformes as $uniforme) {

                // Associe o id da lista ao produto
                $uniforme['id_lista'] = $novaLista->id;

                // Crie o novo produto associado à lista
                $novoProduto = ProdutoLista::create($uniforme);

                // Adiciona o produto salvo à lista de produtos salvos
                $produtosSalvos[] = $novoProduto;
            }

            return response()->json([
                'message' => 'Lista de uniformes salva com sucesso!',
                'produtosSalvos' => $produtosSalvos,
            ], 200);
        } catch (\Exception $e) {
            // Adiciona logs para depuração em caso de erro
            \Log::error('Erro ao salvar lista de uniformes. Detalhes: ' . $e->getMessage());

            return response()->json(['error' => 'Erro ao salvar lista de uniformes. Detalhes: ' . $e->getMessage()], 500);
        }
    }


    

}
