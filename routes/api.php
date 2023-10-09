<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OctaController;
use App\Http\Controllers\Api\OctaAPIController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getContatoBloqueado', [OctaAPIController::class, 'getContatoBloqueado']);
Route::get('/titulos', [OctaAPIController::class, 'getTemplateMensagens']);
Route::post('/cadastrar', [OctaController::class, 'cadastrar']);
Route::post('/salvar-dados', [OctaAPIController::class, 'salvarDados']);
