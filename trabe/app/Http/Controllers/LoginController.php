<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    // Mostrar formulario de login
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['name' => $credentials['name'], 'password' => $credentials['password']], $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->intended(route('home'));
            } else {
                return redirect()->intended(route('dashboard'));
            }
        }

        return back()->withErrors([
            'name' => 'Las credenciales no coinciden.',
        ])->onlyInput('name');
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // Método para mostrar formulario de perfil
    public function perfil()
    {
        return view('perfil');
    }

    public function perfilUser(){
        return view('perfilUser');
    }

    // Método para actualizar perfil
    public function actualizarPerfil(Request $request)
    {
        $user = auth()->user();
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ];
        
        // Si se envía nueva contraseña, validarla y también la actual
        if ($request->filled('new_password')) {
            $rules['current_password'] = 'required|string';
            $rules['new_password'] = 'required|string|min:8|confirmed';
        }
        
        $request->validate($rules);
        
        // Verificar contraseña actual si se va a cambiar algo sensible (email o password)
        if ($request->filled('new_password') || $request->email != $user->email) {
            if (!Hash::check($request->current_password, $user->password)) {
                throw ValidationException::withMessages([
                    'current_password' => 'La contraseña actual es incorrecta.',
                ]);
            }
        }
        
        // Actualizar datos
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }
        
        $user->save();
        
        return redirect()->route('perfil')->with('success', 'Perfil actualizado correctamente.');   
    }
}
