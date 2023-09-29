<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;

class LeadController extends Controller
{
    public function index()
    {
        $clientes = Cliente::with('agendamentos')->get();
        return view('pages.Octa.index', compact('clientes'));
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
    public function atualizarData(Request $request, $id) {

        $cliente = Cliente::findOrFail($id);
      
        $cliente->data_agendamento = $request->data_agendamento;
      
        $cliente->save();
      
        return response()->json(['success' => true]);
      
    }
    public function updateAgendamento(Request $request, $id)
    {
        $data = $request->only(['crm_clientes_id', 'horario']);
    
        $cliente = Cliente::findOrFail($id);
    
        try {
            $cliente->update($data);
            return response()->json(['message' => 'Agendamento atualizado com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha ao atualizar agendamento'], 500);
        }
    }
}
