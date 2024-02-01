<?php

use App\Http\Controllers\ProducaoController;
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
use App\Http\Controllers\ErroController;
use App\Http\Controllers\HomologarPedido;
use App\Http\Controllers\ListaUniformeController;
use App\Http\Controllers\AcessoTemporarioController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\TelaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ProdutoListaController;
use App\Http\Controllers\PedidoExternoController;

Route::middleware(['auth'])->group(function () {
    Route::middleware(['perm.rota'])->group(function () {

        Route::get('/', [SiteController::class, 'index'])->name('index');
        Route::get('/home', [SiteController::class, 'index'])->name('home');
        Route::get('/bandeira', [SiteController::class, 'bandeiras'])->name('bandeira');
        
        Route::get('/gerarLinkCadastroCliente', [AcessoTemporarioController::class, 'index']);
        Route::get('/gerarLinkListaProduto/{id}', [AcessoTemporarioController::class, 'gerarLinkTemporario']);

        Route::prefix('orcamento')->group(function () {
            Route::get('/', [OrcamentosController::class, 'orcamento'])->name('orcamento');
            Route::get('/consultar', [OrcamentosController::class, 'index'])->name('orcamento.index');
            Route::post('/orcamentos-salvar', [OrcamentosController::class, 'salvarOrcamento'])->name('orcamentos.salvar');
            Route::get('/consultarorcamentos/{id}', [OrcamentosController::class, 'consultarOrcamentos'])->name('orcamentos.consultar');
            Route::get('/orcamentoProdutos/{id}', [OrcamentosController::class, 'consultarProdutos'])->name('orcamentos.produtos');
            Route::get('/buscar-orcamentos', [OrcamentosController::class, 'buscarOrcamentos'])->name('orcamentos.buscar');
            
            Route::get('/orcamentos/create', [OrcamentosController::class, 'create'])->name('orcamentos.create');
            // Rota para salvar um novo orçamento
            Route::post('/store', [OrcamentosController::class, 'store'])->name('orcamentos.store');
            // Rota para exibir detalhes de um orçamento
            Route::get('/show/{id}', [OrcamentosController::class, 'show'])->name('orcamentos.show');
            // Rota para exibir o formulário de edição de um orçamento
            Route::get('/edit/{id}', [OrcamentosController::class, 'edit'])->name('orcamentos.edit');
            // Rota para atualizar um orçamento
            Route::put('/update/{id}', [OrcamentosController::class, 'update'])->name('orcamentos.update');
            // Rota para excluir um orçamento
            Route::delete('/destroy/{id}', [OrcamentosController::class, 'destroy'])->name('orcamentos.destroy');
        });
        Route::prefix('pedido')->group(function () {
            Route::any('/', [PedidoController::class, 'artefinal'])->name('pedido');
            Route::put('/{id}', [PedidoController::class, 'update'])->name('pedido.update');
            Route::put('/mover/{id}', [PedidoController::class, 'moverPedido'])->name('pedido.mover');
            Route::post('/criar', [PedidoController::class, 'criarPedido'])->name('pedido.criar');
            Route::delete('/{id}', [PedidoController::class, 'excluirPedido'])->name('pedido.excluir');
        });

        Route::prefix('producao')->group(function () {
            Route::any('/', [ProducaoController::class, 'index']);
            Route::any('/criar', [ProducaoController::class, 'store'])->name('producao.criar');
        });
        Route::prefix('pedidoInterno')->group(function () {
            Route::any('/', [HomologarPedido::class, 'index'])->name('pedidoInterno');
            Route::any('/criar-pedido/{id}', [HomologarPedido::class, 'criarPedidoOrcamento'])->name('pedidoInterno.criar');
            Route::post('/criar', [HomologarPedido::class, 'store'])->name('pedidoInterno.salvar');
            Route::get('/get-produtos-pedido/{id}', [HomologarPedido::class, 'getProdutosDoPedido']);
            Route::post('/atualizar-produto/{pedidoId}/{produtoId}', [HomologarPedido::class, 'update']);
        });

        Route::prefix('produto')->group(function () {
            Route::get('/buscar-por-nome/{nome}', [ProdutoController::class, 'buscarPorNome'])->name('produto.buscarPorNome');
        });
        
        Route::prefix('consultarcadastro')->group(function () {
            Route::any('/', [CadastroController::class, 'consultarCadastros'])->name('cadastro.consulta');
            Route::get('/data', [CadastroController::class, 'getData'])->name('cadastro.data');
            Route::put('/{id}', [CadastroController::class, 'update'])->name('cadastro.update');
        });

        Route::any('/impressao', [PedidoController::class, 'impressaoprovisorio'])->name('impressao');
        Route::any('/confeccao', [PedidoController::class, 'confeccaoprovisorio'])->name('confeccao');
        Route::any('/reposicao', [PedidoController::class, 'reposicaoprovisorio'])->name('reposicao');  


        Route::get('/register', [AuthController::class,'register_page'])->name('register_page');
        Route::post('/register', [AuthController::class,'register'])->name('register');

        Route::prefix('trello')->group(function () {
            Route::any('/', [TrelloController::class, 'index'])->name('trello.index');
        });
        Route::prefix('tiny')->group(function () {
            Route::any('/', [PedidoExternoController::class, 'index'])->name('tiny.relatorio');
        });
        Route::prefix('permissoes')->group(function () {
            // Listar todas as permissões
            Route::get('/', [PermissaoController::class, 'index'])->name('permissoes.index');
        
            // Exibir o formulário de criação de permissão
            Route::get('/create', [PermissaoController::class, 'create'])->name('permissoes.create');
        
            // Processar o formulário de criação de permissão
            Route::post('/store', [PermissaoController::class, 'store'])->name('permissoes.store');
        
            // Exibir detalhes de uma permissão específica
            Route::get('/{id}', [PermissaoController::class, 'show'])->name('permissoes.show');
        
            // Exibir o formulário de edição de uma permissão
            Route::get('/{id}/edit', [PermissaoController::class, 'edit'])->name('permissoes.edit');
        
            // Processar o formulário de edição de permissão
            Route::put('/{id}', [PermissaoController::class, 'update'])->name('permissoes.update');
        
            // Excluir uma permissão
            Route::delete('/{id}', [PermissaoController::class, 'destroy'])->name('permissoes.destroy');
        });
        
        Route::prefix('crm')->group(function () {
            //Route::any('/', [LeadController::class, 'index'])->name('octa.crm');
            Route::any('/', [LeadController::class, 'indexView'])->name('octa.crm');

            Route::any('/getDados', [LeadController::class, 'getDados'])->name('octa.dados');
            Route::put('/{id}', [LeadController::class, 'update'])->name('octa.update');
            Route::put('/atualizar-data/{id}', [LeadController::class, 'atualizarData']);
            Route::post('/atualizar-mensagem', [LeadController::class, 'atualizarMensagem'])->name('octa.atualizarMensagem');
            Route::put('/atualizar-vendedor/{id}', [LeadController::class, 'atualizarVendedor']);
            Route::put('/atualizar-bloqueado/{id}', [LeadController::class, 'atualizarBloqueado']);
            Route::get('/buscar-registros', [LeadController::class, 'buscarRegistros']);
        });
        
        Route::get('/buscar-pedido', [PedidoController::class, 'buscarPedido'])->name('buscarPedido');

        Route::prefix('erros')->group(function () {
            Route::get('/', [ErroController::class, 'index'])->name('erros.index');
            Route::post('/store', [ErroController::class, 'store'])->name('erros.store');
        });
        Route::get('/desenvolvimento', [SiteController::class, 'desenvolvimento'])->name('dev');
    
        Route::prefix('usuarios')->group(function () {
            Route::get('/', [UsuarioController::class, 'index'])->name('usuarios.index');
            Route::get('/create', [UsuarioController::class, 'create'])->name('usuarios.create');
            Route::post('/', [UsuarioController::class, 'store'])->name('usuarios.store');
            Route::post('/upload-imagem', [UsuarioController::class, 'uploadImagem'])->name('usuarios.uploadImagem');

            Route::get('/{id}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
            Route::any('/updateall', [UsuarioController::class, 'update'])->name('usuarios.update');
            Route::delete('/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
            Route::post('/update', [UsuarioController::class, 'updateField'])->name('usuarios.updateField');
        });

        Route::prefix('rotas')->group(function () {
            Route::any('/', [TelaController::class, 'index'])->name('rotas');
            Route::post('/store', [TelaController::class, 'store'])->name('rotas.store');
            Route::post('/update', [TelaController::class, 'update'])->name('rotas.update');
            Route::delete('/destroy/{id}', [TelaController::class, 'destroy'])->name('rotas.destroy');
        });
        
        Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
        
        Route::get('listaUniformes/consultarListas/{id}', [ListaUniformeController::class,'consultarListas']);
        Route::get('listaUniformes/verificarAprovacao/{id}', [ListaUniformeController::class, 'verificarAprovacao']);
        Route::post('listaUniformes/aprovarLista/{id}', [ListaUniformeController::class, 'aprovarLista']);

    });
});

Route::prefix('listaUniformes')->middleware('validar.token')->group(function () {
    //Route::any('/', [ListaUniformeController::class, 'index'])->name('index');
    Route::any('/{id}', [ListaUniformeController::class, 'indexCliente']);
    
});

Route::post('gravarLista', [ProdutoListaController::class,'gravarLista']);

Route::prefix('cadastro')->middleware('validar.token')->group(function () {
    // Rota para listar todos os registros de cadastro
    Route::any('/', [CadastroController::class, 'index'])->name('cadastro.index');
    // Rota para exibir o formulário de criação de cadastro
/*     Route::get('/create', [CadastroController::class, 'create'])->name('cadastro.create');
 */    // Rota para armazenar um novo registro de cadastro
    Route::post('/', [CadastroController::class, 'store'])->name('cadastro.store');
    // Rota para exibir um registro específico de cadastro
    Route::get('/show/{id}', [CadastroController::class, 'show'])->name('cadastro.show');
    /* // Rota para exibir o formulário de edição de cadastro
    Route::get('/{id}/edit', [CadastroController::class, 'edit'])->name('cadastro.edit');
    // Rota para excluir um registro de cadastro
    Route::delete('/{id}', [CadastroController::class, 'destroy'])->name('cadastro.destroy');*/
});

// Rota para exibir um registro específico de cadastro sem validação de token
Route::get('/cadastro/show/{id}', [CadastroController::class, 'show'])->name('cadastro.show');

Route::get('/acessonegado', [CadastroController::class, 'acessonegado'])->name('acessonegado');
Route::get('/sucessocadastro', [CadastroController::class, 'sucessocadastro'])->name('cadastro.sucesso');

Route::get('/', [AuthController::class, 'login_page'])->name('index_login_page')->middleware('guest');
Route::get('/login', [AuthController::class, 'login_page'])->name('login_page')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');

// Rota para logout
Route::post('/logout', [AuthController::class,'logout'])->name('logout');
