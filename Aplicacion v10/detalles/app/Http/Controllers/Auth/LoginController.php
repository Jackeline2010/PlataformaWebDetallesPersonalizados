<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

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
