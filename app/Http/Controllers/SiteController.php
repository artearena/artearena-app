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

     public function frete(){
        $produtos = Produto::all();
        return view('pages.frete', compact('produtos'));
    }

    public function impressao()
    {
        return view('pages.impressao');
    }
}
