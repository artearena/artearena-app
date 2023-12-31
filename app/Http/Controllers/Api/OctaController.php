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
            'id' => 'nullable|integer',
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
            'data_agendamento' => 'nullable|string',
            'status_conversa' => 'nullable|string',
        ]);

        // Aplicar a conversão de caracteres especiais no nome
        $nome = $request->nome;
        $nome = mb_convert_encoding($nome, 'HTML-ENTITIES', 'UTF-8');

        // Criar um novo cliente com os dados recebidos
        $cliente = Cliente::create([
            'nome' => $nome,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'origem' => $request->origem,
            'url_octa' => $request->url_octa,
            'id' => $request->id,
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
            'data_agendamento' => $request->data_agendamento,
            'status_conversa' => $request->status_conversa,
        ]);

        // Salvar o cliente no banco de dados
        $cliente->save();

        // Registrar mensagem de log
        info('Cliente cadastrado com sucesso!');

        // Retornar uma resposta de sucesso
        return response()->json(['message' => 'Cliente cadastrado com sucesso!']);
    }
}