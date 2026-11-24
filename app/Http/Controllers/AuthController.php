<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credenciales = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credenciales)) {
            return back()
                ->withErrors(['email' => 'Correo o contraseña incorrectos.'])
                ->onlyInput('email');
        }

        // Nuevo ID de sesión tras autenticarse (previene fijación de sesión).
        $request->session()->regenerate();

        return redirect()->intended(route('equipos.index'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        // Solo cierra la sesión de ESTE navegador; no toca las demás filas de `sessions`.
        Auth::logout();

        $request->session()->invalidate();     // borra los datos y genera un ID nuevo
        $request->session()->regenerateToken(); // nuevo token CSRF

        return redirect()->route('login')->with('success', 'Cerraste sesión correctamente.');
    }
}
