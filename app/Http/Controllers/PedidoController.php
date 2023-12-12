<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Usuario;
use App\Models\Material;
use App\Models\CategoriaProduto;

class PedidoController extends Controller
{
    public function artefinal()
    {
        $pedidos = Pedido::all();
        $designers = Usuario::where('permissoes', 2)->pluck('nome_usuario');
        $categoriasProduto = CategoriaProduto::all(); // Buscar todas as categorias de produto
        $materiais = Material::all();
        $pedidos = Pedido::orderBy('id', 'desc')->get();

        return view('pages.artefinal', compact('pedidos', 'designers', 'categoriasProduto', 'materiais'));
    }
    public function artefinal2()
    {
        $pedidos = Pedido::all();
        $designers = Usuario::where('permissoes', 2)->pluck('nome_usuario');
        $categoriasProduto = CategoriaProduto::all(); // Buscar todas as categorias de produto
        $materiais = Material::all();

        return view('pages.artefinal2', compact('pedidos', 'designers', 'categoriasProduto', 'materiais'));
    }
    public function impressaoprovisorio()
    {
        $pedidos = Pedido::all();
        $designers = Usuario::where('permissoes', 2)->pluck('nome_usuario');
        $categoriasProduto = CategoriaProduto::all(); // Buscar todas as categorias de produto
        $materiais = Material::all();

        return view('pages.impressao', compact('pedidos', 'categoriasProduto', 'materiais'));
    }
    public function reposicaoprovisorio ()
    {
        $pedidos = Pedido::all();
        $designers = Usuario::where('permissoes', 2)->pluck('nome_usuario');
        $categoriasProduto = CategoriaProduto::all(); // Buscar todas as categorias de produto
        $materiais = Material::all();

        return view('pages.reposicao', compact('pedidos' , 'categoriasProduto', 'materiais'));
    }
    public function confeccaoprovisorio()
    {
        $pedidos = Pedido::all();
        $designers = Usuario::where('permissoes', 2)->pluck('nome_usuario');
        $categoriasProduto = CategoriaProduto::all(); // Buscar todas as categorias de produto
        $materiais = Material::all();

        return view('pages.confeccao', compact('pedidos', 'designers', 'categoriasProduto', 'materiais'));
    }
    
    public function update(Request $request, $id)
    {
        $pedido = Pedido::find($id);
        $pedido->update($request->only([
            'id',
            'data',
            'produto',
            'material',
            'medida_linear',
            'observacoes',
            'dificuldade',
            'status',
            'designer',
            'tipo_pedido',
            'checagem_final',
            'link_trello',
            'rolo',
            'observacao_reposicao'
        ]));

        return response()->json([
            'message' => 'Pedido updated successfully!'
        ], 200);
    }
    public function buscarPedido(Request $request)
    {
        $numeroPedido = $request->input('numeroPedido');
        // Faça a lógica para buscar os dados do pedido com base no número fornecido
        $pedido = Pedido::where('id', $numeroPedido)->first();
        // Retorne os dados do pedido como uma resposta JSON
        if (!$pedido) {
            return response()->json([
                'error' => 'Pedido não encontrado'
            ], 404);
        }

        return response()->json($pedido);
    }
    
    public function moverPedido($id)
    {
        // Encontrar o pedido pelo ID
        $pedido = Pedido::findOrFail($id);

        // Atualizar a etapa do pedido com a nova etapa selecionada
        $etapa = request()->input('etapa');
        $pedido->etapa = $etapa;
        $pedido->save();

        // Retornar uma resposta de sucesso
        return response()->json(['message' => 'Pedido movido com sucesso']);
    }
    
    public function criarPedido(Request $request)
    {
        try {
            $pedido = new Pedido();
            $id = $request->input('id');
            if ($id !== null) {
                $pedido->id = $id;
            }
            $pedido->data = $request->input('data');
            $pedido->produto = $request->input('produto');
            $pedido->material = $request->input('material');
            $pedido->medida_linear = $request->input('medida_linear');
            $pedido->observacoes = $request->input('observacoes');
            $pedido->status = $request->input('status');
            $pedido->designer = $request->input('designer');
            $pedido->tipo_pedido = $request->input('tipo_pedido');
            $pedido->checagem_final = $request->input('checagem_final');
            $pedido->link_trello = $request->input('link_trello');
            $pedido->etapa = $request->input('etapa'); // Defina a etapa inicial do pedido
            $pedido->rolo = $request->input('rolo');
            $pedido->observacao_reposicao = $request->input('observacao_reposicao');

            $pedido->save();

            return response()->json([
                'message' => 'Pedido created successfully!',
                'pedido' => $pedido // Retorna o objeto do pedido criado para atualização da tabela
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar o pedido: ' . $pedido . $e->getMessage()], 500);
        }
    }

    public function excluirPedido($id)
    {
       try{
            // Encontre o pedido pelo ID
            $pedido = Pedido::find($id);

            // Verifique se o pedido foi encontrado
            if (!$pedido) {
                return redirect()->back()->with('error', 'Pedido não encontrado.');
            }

            // Excluir o pedido
            $pedido->delete();

            return redirect()->back()->with('message', 'Pedido excluído com sucesso.');
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao excluir o pedido: ' . $pedido . $e->getMessage()], 500);
        }
    }

}
