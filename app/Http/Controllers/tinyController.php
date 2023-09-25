<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tiny;
use PDF; 

class tinyController extends Controller
{

    public function gerarPdf()
    {
        $dados = Tiny::getAllData();

        $pdf = PDF::loadView('relatorioPdf', compact('dados'));
        return $pdf->download('relatorio.pdf');
    }

    public function exibirRelatorio() 
    {
        $dados = Tiny::getAllData();
        
        return view('relatorioTela', compact('dados')); 
    }

}