<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TemplateMensagem;

class OctaAPIController extends Controller
{
    public function getTemplateMensagens()
    {
        $templateMensagens = TemplateMensagem::all();
    
        return response()->json($templateMensagens);
    }
}
