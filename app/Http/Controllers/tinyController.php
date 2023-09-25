<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tiny;
use PDF; 

class tinyController extends Controller
{

    public function gerarPdf()
    {
        $dados = tiny::All();

        $pdf = PDF::loadView('relatorioPdf', compact('dados'));
        return $pdf->download('relatorio.pdf');
    }

    public function exibirRelatorio() 
    {
        $dados = tiny::selectRaw('SUM(total_pedido) AS total_pedido, 
            SUM(valor_frete) AS total_frete, 
            id_vendedor')
        ->groupBy('id_vendedor')
        ->get();

        return view('pages.tiny.relatorio', compact('dados')); 
    }
}