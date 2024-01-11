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