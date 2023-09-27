<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;

class LeadController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('pages.Octa.index', compact('clientes'));
    }
}
