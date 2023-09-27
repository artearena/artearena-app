<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;

class OctaController extends Controller
{
    public function cadastrar(Request $request)
    {
        info('Dados recebidos na API:', $request->all());
        // Validar os dados recebidos
        $request->validate([
            'nome' => 'required',
            'telefone' => 'nullable|string',
            'email' => 'nullable|email',
            'origem' => 'nullable|string',
            'id_octa' => 'nullable|integer',
        ]);

        // Criar um novo cliente
        $cliente = new Cliente([
            'nome' => $request->input('nome'),
            'telefone' => $request->input('telefone'),
            'email' => $request->input('email'),
            'origem' => $request->input('origem'),
            'id_octa' => $request->input('id_octa'),
        ]);

        // Salvar o cliente no banco de dados
        $cliente->save();
        
        // Registrar mensagem de log
        info('Cliente cadastrado com sucesso!');
        // Retornar uma resposta de sucesso
        return response()->json(['message' => 'Cliente cadastrado com sucesso!']);
    }
}