<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Permissao;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        $permissoes = Permissao::all();

        return view('pages.usuarios.index', compact('usuarios', 'permissoes'));
    }

    public function create()
    {
        return view('pages.usuarios.create');
    }

    public function store(Request $request)
    {
        $usuario = new Usuario([
            'nome_usuario' => $request->get('nome_usuario'),
            'permissoes' => $request->get('permissoes'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'id_vendedor' => $request->get('id_vendedor'),
        ]);
        $usuario->save();
        return redirect('/usuarios')->with('success', 'Usuário salvo!');
    }


    public function edit($id)
    {
        $usuario = Usuario::find($id);
        return view('pages.usuarios.edit', compact('usuario'));
    }
    
    public function uploadImagem(Request $request)
    {
        // Verifica se há uma imagem enviada
        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            // Obtém o conteúdo do arquivo da imagem
            $imagem = $request->file('imagem');
            $conteudoImagem = file_get_contents($imagem->getRealPath());
    
            // Atualiza o usuário com o conteúdo da imagem no banco de dados
            $usuario = Usuario::find($request->id);
            if ($usuario) {
                $usuario->foto_perfil = $conteudoImagem;
                $usuario->save();
                
                return response()->json(['success' => 'Imagem enviada e usuário atualizado!']);
            } else {
                return response()->json(['error' => 'Usuário não encontrado!'], 404);
            }
        } else {
            return response()->json(['error' => 'Falha ao enviar a imagem!'], 400);
        }
    }
    
    public function update(Request $request)
    {
        $usuario = Usuario::find($request->id);
        
        if (!$usuario) {
            return response()->json(['error' => 'Usuário não encontrado!'], 404);
        }
    
        if ($request->field == 'password') {
            // Se o campo for 'password', atualize a senha
            $usuario->update(['password' => bcrypt($request->value)]);
        } else {
            // Para outros campos, atualize normalmente
            $value = $request->value;
            $usuario->{$request->field} = $value;
            $usuario->save();
        }
    
        return response()->json(['success' => 'Usuário atualizado!']);
    }
    
    

    public function destroy($id)
    {
        $usuario = Usuario::find($id);
        $usuario->delete();
        return redirect('/usuarios')->with('success', 'Usuário deletado!');
    }
}