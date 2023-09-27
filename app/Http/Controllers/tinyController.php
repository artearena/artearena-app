<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tiny;
use App\Models\Usuario;
use PDF;

class TinyController extends Controller
{
    public function gerarPdf()
    {
        $dados = tiny::all();
        $pdf = PDF::loadView('relatorioPdf', compact('dados'));
        return $pdf->download('relatorio.pdf');
    }

    public function exibirRelatorio()
    {
        $dados = tiny::selectRaw('SUM(total_pedido) AS total_pedido, SUM(valor_frete) AS total_frete, id_vendedor')
            ->groupBy('id_vendedor')
            ->get();
        
        $vendedores = Usuario::whereNotNull('id_vendedor')->select('id_vendedor', 'nome_usuario')->get();
        return view('pages.tiny.relatorio', compact('dados', 'vendedores'));
    }
}