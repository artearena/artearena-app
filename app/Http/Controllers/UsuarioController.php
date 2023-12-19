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

    public function update(Request $request, $id)
{
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return redirect('/usuarios')->with('error', 'Usuário não encontrado!');
        }

        $usuario->nome_usuario = $request->get('nome_usuario');
        $usuario->permissoes = $request->get('permissoes');
        $usuario->email = $request->get('email');
        $usuario->password = bcrypt($request->get('password'));
        $usuario->id_vendedor = $request->get('id_vendedor');
        $usuario->save();

        return redirect('/usuarios')->with('success', 'Usuário atualizado!');
    }

    public function destroy($id)
    {
        $usuario = Usuario::find($id);
        $usuario->delete();
        return redirect('/usuarios')->with('success', 'Usuário deletado!');
    }
}