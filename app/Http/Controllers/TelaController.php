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
        $telas = Tela::create($request->all());
        return response()->json($telas, 200);
    }

    public function update(Request $request)
    {
        $telas = Tela::find($request->id);
        $telas->{$request->field} = $request->value;
        $telas->save();
    }
    
}