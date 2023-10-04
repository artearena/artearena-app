<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TemplateMensagem;
use App\Models\Cliente;

class OctaAPIController extends Controller
{
    public function getTemplateMensagens()
    {
        $templateMensagens = TemplateMensagem::all();
    
        return response()->json($templateMensagens);
    }
    public function salvarDados(Request $request)
    {
        $id_octa = $request->input('id_octa');
        $responsavel_contato = $request->input('responsavel_contato');
        $mensagem_template_id = $request->input('mensagem_template_id');
        $data_agendamento = $request->input('data_agendamento');

        $cliente = Cliente::where('id_octa', $id_octa)->first();

        if ($cliente) {
            $cliente->responsavel_contato = $responsavel_contato;
            $cliente->mensagem_template_id = $mensagem_template_id;
            $cliente->data_agendamento = $data_agendamento;
            $cliente->save();

            return response()->json(['message' => 'Dados salvos com sucesso!']);
        }

        return response()->json(['message' => 'Cliente não encontrado.']);
    }
}
