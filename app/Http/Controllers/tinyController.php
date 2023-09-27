<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tiny;
use App\Models\Usuario;
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
        $vendedores = Usuarios::whereNotNull('id_vendedor')->pluck('nome_usuario');

        return view('pages.tiny.relatorio', compact('dados', 'vendedores')); 
    }
}