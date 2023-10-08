<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Erro;

class ErroController extends Controller
{
    public function create()
    {
        return view('page.Erros.index');
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

        Erro::create($validatedData);

        return back()->with('success', 'Erro cadastrado com sucesso!');
    }
}