<?php

namespace App\Http\Controllers;

use App\Models\Log_pedidos;
use App\Models\Usuario;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $query = Log_pedidos::with('usuario')->orderBy('id', 'desc');
        $usuario = Usuario::all();

        if ($request->search) {
            $query->where('id_pedido', 'like', '%' . $request->search . '%');
        }

        $logs = $query->paginate(10);

        return view('pages.logs.index', compact('logs','usuario'));
    }
}