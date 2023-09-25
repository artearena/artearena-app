<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tiny;
use PDF; 

class tinyController extends Controller
{

    public function relatorio()
    {
        $tiny = tiny::selectRaw('SUM(total_pedido) AS total_pedido, SUM(valor_frete) AS total_frete, id_vendedor')
        ->groupBy('id_vendedor')
        ->get();
        
        $pdf = PDF::loadView('relatorio', compact('tiny'));
        return $pdf->download('relatorio-tiny.pdf');
    }

}