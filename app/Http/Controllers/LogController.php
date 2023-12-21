<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Usuario;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $query = Log::with('usuario');

        if ($request->search) {
            $query->where('descricao', 'like', '%' . $request->search . '%');
        }

        $logs = $query->paginate(10);

        return view('logs.index', compact('logs'));
    }
}