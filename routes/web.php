<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PermissaoController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\TrelloController;
use App\Http\Controllers\tinyController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\OrcamentosController;

Route::middleware(['auth'])->group(function () {
    Route::get('/', [SiteController::class, 'index'])->name('index');
    Route::get('/home', [SiteController::class, 'index'])->name('home');
    
    Route::get('/bandeira', [SiteController::class, 'bandeiras'])->name('bandeira');
    
    Route::prefix('frete')->group(function () {
        Route::get('/', [SiteController::class, 'frete'])->name('frete');
        Route::post('/orcamentos-salvar', [OrcamentosController::class, 'salvarOrcamento'])->name('orcamentos.salvar');
    });
    Route::prefix('pedido')->group(function () {
        Route::any('/', [PedidoController::class, 'artefinal'])->name('pedido');
        Route::put('/{id}', [PedidoController::class, 'update'])->name('pedido.update');
        Route::put('/mover/{id}', [PedidoController::class, 'moverPedido'])->name('pedido.mover');
        Route::post('/criar', [PedidoController::class, 'criarPedido'])->name('pedido.criar');
        Route::delete('/{id}', [PedidoController::class, 'excluirPedido'])->name('pedido.excluir');
    });
    Route::prefix('consultarcadastro')->group(function () {
        Route::any('/', [CadastroController::class, 'consultarCadastros'])->name('cadastro.consulta');
        Route::get('/data', [CadastroController::class, 'getData'])->name('cadastro.data');
        Route::put('/{id}', [CadastroController::class, 'update'])->name('cadastro.update');
    });

    Route::any('/impressao', [PedidoController::class, 'impressaoprovisorio'])->name('impressao');
    Route::any('/confeccao', [PedidoController::class, 'confeccaoprovisorio'])->name('confeccao');
    Route::any('/reposicao', [PedidoController::class, 'reposicaoprovisorio'])->name('reposicao');  

    Route::resource('permissao', PermissaoController::class)->except(['show']);

    Route::get('/register', [AuthController::class,'register_page'])->name('register_page');
    Route::post('/register', [AuthController::class,'register'])->name('register');

    Route::prefix('trello')->group(function () {
        Route::any('/', [TrelloController::class, 'index'])->name('trello.index');
    });
    Route::prefix('tiny')->group(function () {
        Route::any('/', [tinyController::class, 'exibirRelatorio'])->name('tiny.relatorio');
        Route::any('/download-pdf', [tinyController::class, 'gerarPdf'])->name('tiny.gerarPdf');
    });
    Route::prefix('crm')->group(function () {
        Route::any('/', [LeadController::class, 'index'])->name('octa.crm');
        Route::put('/{id}', [LeadController::class, 'update'])->name('octa.update');
        Route::put('/atualizar-data/{id}', [LeadController::class, 'atualizarData']);
        Route::post('/atualizar-mensagem', [LeadController::class, 'atualizarMensagem'])->name('octa.atualizarMensagem');
        Route::put('/atualizar-vendedor/{id}', [LeadController::class, 'atualizarVendedor']);
        Route::put('/atualizar-bloqueado/{id}', [LeadController::class, 'atualizarBloqueado']);

    });
});

Route::prefix('cadastro')->group(function () {
    // Rota para listar todos os registros de cadastro
    Route::any('/', [CadastroController::class, 'index'])->name('cadastro.index');

    // Rota para exibir o formulário de criação de cadastro
    Route::get('/create', [CadastroController::class, 'create'])->name('cadastro.create');

    // Rota para armazenar um novo registro de cadastro
    Route::post('/', [CadastroController::class, 'store'])->name('cadastro.store');

    // Rota para exibir um registro específico de cadastro
    Route::get('/{id}', [CadastroController::class, 'show'])->name('cadastro.show');

    // Rota para exibir o formulário de edição de cadastro
    Route::get('/{id}/edit', [CadastroController::class, 'edit'])->name('cadastro.edit');

    // Rota para excluir um registro de cadastro
    Route::delete('/{id}', [CadastroController::class, 'destroy'])->name('cadastro.destroy');
});

Route::get('/', [AuthController::class, 'login_page'])->name('index_login_page')->middleware('guest');
Route::get('/login', [AuthController::class, 'login_page'])->name('login_page')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');

// Rota para logout
Route::post('/logout', [AuthController::class,'logout'])->name('logout');
