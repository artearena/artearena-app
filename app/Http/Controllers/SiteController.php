<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class SiteController extends Controller
{

    public function index()
    {
        return view('pages.index');
    }
    
    public function bandeiras()
    {
        return view('pages.bandeiras');
    }

    public function desenvolvimento()
    {
        return view('pages.desenvolvimentos.index');
    }

    public function orcamento(){
        $produtos = Produto::all();
        return view('pages.orcamento.gerarOrcamento', compact('produtos'));
    }


}
