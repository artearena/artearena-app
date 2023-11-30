<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto; // Certifique-se de importar o modelo Produto ou ajustar conforme sua estrutura

class ProdutoController extends Controller
{
    public function buscarPorNome($nome)
    {
        // Lógica para buscar o produto por nome
        $produto = Produto::where('NOME', $nome)->first();

        // Retorne o resultado, ajuste conforme necessário
        return response()->json($produto);
    }

    // Adicione outros métodos relacionados a produtos, se necessário
}

