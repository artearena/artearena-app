<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrelloController extends Controller
{
    public function index()
    {
        return view('pages.trello.index');
    }
}
