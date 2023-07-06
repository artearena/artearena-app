<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Rotas de auth
    public function login_page(){
        return view('pages.login');
    }
    public function register_page(){
        return view('pages.cadastros');
    }
    // Método para registro de usuários
    public function register(Request $request)
    {
        // Validação dos campos do formulário
        $validatedData = $request->validate([
            'nome_usuario' => 'required',
            'permissoes' => 'required',
            'email' => 'required|email|unique:usuarios',
            'password' => 'required',
        ]);

        // Criação do usuário no banco de dados
        $user = Usuario::create([
            'nome_usuario' => $validatedData['nome_usuario'],
            'permissoes' => $validatedData['permissoes'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Autenticação do usuário recém-criado
        Auth::login($user);

        // Redirecionamento após o registro
        return redirect('/home');
    }

    // Método para login de usuários
    public function login(Request $request)
    {
        // Validação dos campos do formulário
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Autenticação do usuário
        if (Auth::attempt($credentials)) {
            // Autenticação bem-sucedida
            return redirect('/home');
        } else {
            // Autenticação falhou
            return redirect()->back()->withErrors(['message' => 'Credenciais inválidas.']);
        }
    }

    // Método para logout de usuários
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
