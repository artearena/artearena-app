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
            'url_octa' => 'nullable|string',
            'id_octa' => 'nullable|string',
        ]);

        // Criar um novo cliente com os dados recebidos
        $cliente = Cliente::create([
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'origem' => $request->origem,
            'url_octa' => $request->url_octa,
            'id_octa' => $request->id_octa,
        ]);
        // Salvar o cliente no banco de dados
        $cliente->save();
        
        // Registrar mensagem de log
        info('Cliente cadastrado com sucesso!');
        // Retornar uma resposta de sucesso
        return response()->json(['message' => 'Cliente cadastrado com sucesso!']);
    }
}