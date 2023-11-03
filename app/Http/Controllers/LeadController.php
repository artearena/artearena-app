<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\TemplateMensagem;
use App\Models\Usuario;

class LeadController extends Controller
{
    public function index()
    {
        $clientes = Cliente::with('agendamentos', 'templateMensagem')
            ->orderBy('created_at', 'desc')
            ->take(1000) // Limita a 200 registros
            ->get()
            ->groupBy('telefone')
            ->map(function ($grupo) {
                return $grupo->first();
            });

        $mensagens = TemplateMensagem::all();
        $vendedores = Usuario::whereIn('permissoes', [17, 18])->pluck('nome_usuario');

        return view('pages.Octa.index', compact('clientes', 'mensagens', 'vendedores'));
    }

    public function update(Request $request, $id) 
    {
        $registro = Cliente::findOrFail($id);

        try {
            $registro->update($request->all());
            return response()->json(['message' => 'Registro atualizado com sucesso!']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha ao atualizar registro'], 500);
        }
    }
    public function atualizarData(Request $request, $id)
    {
        $newDateTime = $request->input('newDateTime');
        
        // Atualizar o registro no banco de dados
        $cliente = Cliente::findOrFail($id);
        $cliente->data_agendamento = $newDateTime;
        $cliente->save();
    
        return response()->json(['success' => true]);
    }
    public function updateAgendamento(Request $request, $id)
    {
        $data = $request->only(['cliente_id', 'horario']);
    
        $cliente = Cliente::findOrFail($id);
    
        try {
            $cliente->update($data);
            return response()->json(['message' => 'Agendamento atualizado com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha ao atualizar agendamento'], 500);
        }
    }
    public function atualizarMensagem(Request $request)
    {
        $clienteId = $request->input('clienteId');
        $mensagemId = $request->input('mensagemId');

        // Atualizar o registro no banco de dados
        $cliente = Cliente::find($clienteId);
        $cliente->mensagem_template_id = $mensagemId;
        $cliente->save();

        return response()->json(['success' => true]);
    }
    public function atualizarVendedor(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->responsavel_contato = $request->input('responsavel_contato');
        $cliente->save();
    
        return response()->json(['message' => 'Vendedor atualizado com sucesso!']);
    }
    public function atualizarBloqueado(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $cliente->contato_bloqueado =  $request->input('bloqueado') ;

        $cliente->save();

        return response()->json(['message' => 'Bloqueado atualizado com sucesso!']);
    }
}

