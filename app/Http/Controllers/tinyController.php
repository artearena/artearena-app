<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tiny;

class tinyController extends Controller
{
    public function relatorio()
    {
        $tiny = tiny::all();
        return view('pages.tiny.relatorio', compact('tiny'));
    }
}
