<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Usuario;
use App\Models\CategoriaProduto;

class PedidoController extends Controller
{
    public function artefinal()
    {
        $pedidos = Pedido::all();
        $designers = Usuario::where('permissoes', 2)->pluck('nome_usuario');
        $categoriasProduto = CategoriaProduto::all(); // Buscar todas as categorias de produto

        return view('pages.artefinal', compact('pedidos', 'designers', 'categoriasProduto'));
    }

    public function update(Request $request, $id)
{
    $pedido = Pedido::find($id);
    $pedido->update($request->only([
        'data',
        'produto',
        'material',
        'medida_linear',
        'observacoes',
        'status',
        'designer',
        'tipo_pedido',
        'checagem_final',
        'tiny'
    ]));

    return response()->json([
        'message' => 'Pedido updated successfully!'
    ], 200);
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
        $pedido = new Pedido();
        $pedido->pedido = $request->input('pedido');
        $pedido->data = $request->input('data');
        $pedido->produto = $request->input('produto');
        $pedido->material = $request->input('material');
        $pedido->medida_linear = $request->input('medida_linear');
        $pedido->observacoes = $request->input('observacoes');
        $pedido->status = $request->input('status');
        $pedido->designer = $request->input('designer');
        $pedido->tipo_pedido = $request->input('tipo_pedido');
        $pedido->checagem_final = $request->input('checagem_final');
        $pedido->tiny = $request->input('tiny');
        $pedido->etapa = 'A'; // Defina a etapa inicial do pedido

        $pedido->save();

        return response()->json([
            'message' => 'Pedido created successfully!',
            'pedido' => $pedido // Retorna o objeto do pedido criado para atualização da tabela
        ], 200);
    }
    public function excluirPedido($id)
    {
        // Encontre o pedido pelo ID
        $pedido = Pedido::find($id);
    
        // Verifique se o pedido foi encontrado
        if (!$pedido) {
            return redirect()->back()->with('error', 'Pedido não encontrado.');
        }
    
        // Excluir o pedido
        $pedido->delete();
    
        return redirect()->back()->with('message', 'Pedido excluído com sucesso.');
    }
    
}
