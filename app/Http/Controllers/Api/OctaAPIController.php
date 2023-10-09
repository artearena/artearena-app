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
        $id = $request->input('id');
        $responsavel_contato = $request->input('responsavel_contato');
        $mensagem_template_id = $request->input('mensagem_template_id');
        $data_agendamento = $request->input('data_agendamento');

        $cliente = Cliente::where('id', $id)->first();
        info($request);

        if ($cliente) {
            $cliente->responsavel_contato = $responsavel_contato;
            $cliente->mensagem_template_id = $mensagem_template_id;
            $cliente->data_agendamento = $data_agendamento;
            $cliente->save();
            // Registrar mensagem de log
            info('Cliente cadastrado com sucesso!');
            return response()->json(['message' => 'Dados salvos com sucesso!']);
        }
        // Registrar mensagem de log
        info('Cliente não encontrado!');
        return response()->json(['message' => 'Cliente não encontrado.']);
    }
    public function getContatoBloqueado(Request $request)
    {
        $contatoCliente = $request->input('contato_cliente');
        $contatoClienteSemEspacos = str_replace(['+', ' '], '', $contatoCliente);
        info($contatoClienteSemEspacos);
        $clientes = Cliente::all();
        $clienteEncontrado = null;
        foreach ($clientes as $cliente) {
            $telefone = str_replace(['+', ' '], '', $cliente->telefone);
            if ($telefone === $contatoClienteSemEspacos) {
                info($telefone);
                $clienteEncontrado = $cliente;
                break;
            }
        }
        if ($clienteEncontrado) {
            $contatoBloqueado = $clienteEncontrado->contato_bloqueado;
            if ($contatoBloqueado == 1) {
                return response()->json(['contato_bloqueado' => $contatoBloqueado]);
            }
            else if($contatoBloqueado == 0){
                return response()->json(['error' => 'Cliente não bloqueado'], 400);
            }
        }
        return response()->json(['error' => 'Cliente não bloqueado'], 400);
    }
    
}
