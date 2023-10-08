<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Erros;

class ErroController extends Controller
{
    public function index()
    {
        $erros = Erros::all();
        return view('pages.Erros.index', compact('erros'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'departamento' => 'nullable',
            'data' => 'nullable|date',
            'responsavel' => 'nullable',
            'pedido' => 'nullable',
            'tipo_produto' => 'nullable',
            'tipo_erro' => 'nullable',
            'erro' => 'nullable',
            'consequencia_erro' => 'nullable',
            'custo' => 'nullable|numeric',
            'descontado' => 'nullable|numeric',
        ]);

        Erros::create($validatedData);

        return back()->with('success', 'Erro cadastrado com sucesso!');
    }
}