<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Lang;
class LoginController extends Controller
{
    use AuthenticatesUsers;


    protected function credentials(\Illuminate\Http\Request $request)
{
    return [
        'email' => $request->email,
        'password' => $request->password,
        'activo' => 1,
    ];
}
protected function sendFailedLoginResponse(\Illuminate\Http\Request $request)
{
    $user = \App\Models\User::where('email', $request->email)->first();

    // Si existe pero está inactivo
    if ($user && !$user->activo) {
        return back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => 'Tu cuenta está inactiva. Contacta al administrador.'
            ]);
    }

    // Caso normal: credenciales incorrectas
    throw ValidationException::withMessages([
        $this->username() => [Lang::get('auth.failed')],
    ]);
}

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirección automática según rol
     */
  protected function redirectTo()
{
    if (Auth::user()->role === 'admin') {
        return route('admin.dashboard');
    }

    return route('client.dashboard'); //  CLIENTE
}
}
