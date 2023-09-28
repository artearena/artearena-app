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
            'id_octa' => 'nullable|integer',
            'primeira_mensagem_cliente' => 'nullable|string',
            'responsavel_contato' => 'nullable|string',
            'tel_comercial_contato' => 'nullable|string',
            'tel_residencial_contato' => 'nullable|string',
            'status_do_contato' => 'nullable|string',
            'numero_de_pedido_contato' => 'nullable|string',
            'nome_organizacao' => 'nullable|string',
            'primeiro_telefone_organizacao' => 'nullable|string',
            'primeiro_dominio_organizacao' => 'nullable|string',
            'empresa' => 'nullable|string',
        ]);
        // Criar um novo cliente com os dados recebidos
        $cliente = Cliente::create([
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'origem' => $request->origem,
            'url_octa' => $request->url_octa,
            'id_octa' => $request->id_octa,
            'primeira_mensagem_cliente' => $request->primeira_mensagem_cliente,
            'responsavel_contato' => $request->responsavel_contato,
            'tel_comercial_contato' => $request->tel_comercial_contato,
            'tel_residencial_contato' => $request->tel_residencial_contato,
            'status_do_contato' => $request->status_do_contato,
            'numero_de_pedido_contato' => $request->numero_de_pedido_contato,
            'nome_organizacao' => $request->nome_organizacao,
            'primeiro_telefone_organizacao' => $request->primeiro_telefone_organizacao,
            'primeiro_dominio_organizacao' => $request->primeiro_dominio_organizacao,
            'empresa' => $request->empresa,
        ]);
        
        // Salvar o cliente no banco de dados
        $cliente->save();
        
        // Registrar mensagem de log
        info('Cliente cadastrado com sucesso!');
        // Retornar uma resposta de sucesso
        return response()->json(['message' => 'Cliente cadastrado com sucesso!']);
    }
}