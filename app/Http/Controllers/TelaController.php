<?php

namespace App\Http\Controllers;

use App\Models\telas;
use Illuminate\Http\Request;

class TelaController extends Controller
{
    public function index()
    {
        $telas = telas::all();
        return view('pages.rotas.index', compact('telas'));
    }

    public function create()
    {
        return view('pages.rotas.create');
    }

    public function store(Request $request)
    {
        $tela = telas::create($request->all());
        return response()->json($tela, 200);
    }

    public function update(Request $request)
    {
        $tela = telas::find($request->id);
        $tela->{$request->field} = $request->value;
        $tela->save();
    }
    
}