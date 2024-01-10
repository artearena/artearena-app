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

    public function show($id)
    {
        $usuario = Usuario::find($id);
        return view('pages.usuarios.show', compact('usuario'));
    }

    public function edit($id)
    {
        $usuario = Usuario::find($id);
        return view('pages.usuarios.edit', compact('usuario'));
    }
/* 
    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($request->id);
    
        if (!$usuario) {
            return response()->json(['error' => 'Usuário não encontrado!'], 404);
        }
    
        $value = $request->field == 'password' ? bcrypt($request->value) : $request->value;
        $usuario->{$request->field} = $value;
        $usuario->save();
    
        return response()->json(['success' => 'Usuário atualizado!']);
    } */
    public function editarSenha(Request $request)
    {
        $usuario = Usuario::find($request->id);
    
        if (!$usuario) {
            return response()->json(['error' => 'Usuário não encontrado!'], 404);
        }
    
        $usuario->update(['password' => bcrypt($request->novaSenha)]);
    
        return response()->json(['success' => 'Senha editada com sucesso!']);
    }
    

    public function destroy($id)
    {
        $usuario = Usuario::find($id);
        $usuario->delete();
        return redirect('/usuarios')->with('success', 'Usuário deletado!');
    }
}