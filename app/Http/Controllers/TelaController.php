<?php

namespace App\Http\Controllers;

use App\Models\Tela;
use Illuminate\Http\Request;

class TelaController extends Controller
{
    public function index()
    {
        $Tela = Tela::all();
        return view('pages.rotas.index', compact('Tela'));
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

    public function update(Request $request)
    {
        $tela = Tela::find($request->id);
        $tela->{$request->field} = $request->value;
        $tela->save();
    }
    
}