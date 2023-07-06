<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PedidoController;

Route::middleware(['auth'])->group(function () {
    Route::get('/', [SiteController::class, 'index'])->name('index');
    Route::get('/home', [SiteController::class, 'index'])->name('home');
    Route::get('/frete', [SiteController::class, 'frete'])->name('frete');
    Route::get('/bandeira', [SiteController::class, 'bandeiras'])->name('bandeira');
    
    Route::get('/artefinal', [PedidoController::class, 'artefinal'])->name('artefinal');
    Route::group(['prefix' => 'pedido'], function () {
        Route::put('/{id}', [PedidoController::class, 'update'])->name('pedido.update');
        Route::put('/mover/{id}', [PedidoController::class, 'moverPedido'])->name('pedido.mover');
        Route::post('/criar', [PedidoController::class, 'criarPedido'])->name('pedido.criar');
        Route::delete('/excluir/{id}', [PedidoController::class, 'excluirPedido'])->name('pedido.excluir');
    });
    // testando só 
    Route::get('/impressao', [SiteController::class, 'impressao'])->name('impressao');
    Route::get('/confeccao', [SiteController::class, 'confeccao'])->name('confeccao');
});

Route::get('/', [AuthController::class, 'login_page'])->name('index_login_page')->middleware('guest');
Route::get('/login', [AuthController::class, 'login_page'])->name('login_page')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');

Route::get('/register', [AuthController::class,'register_page'])->name('register_page');
Route::post('/register', [AuthController::class,'register'])->name('register');

// Rota para logout
Route::post('/logout', [AuthController::class,'logout'])->name('logout');


