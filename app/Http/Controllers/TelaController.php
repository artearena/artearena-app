<?php

namespace App\Http\Controllers;

use App\Models\Tela;
use Illuminate\Http\Request;

class TelaController extends Controller
{
    public function index()
    {
        $telas = Tela::all();
        return view('pages.rotas.index', compact('telas'));
    }

    public function create()
    {
        return view('pages.rotas.create');
    }

    public function store(Request $request)
    {
        $tela = Tela::create($request->all());
        return response()->json($tela, 200);
    }
}