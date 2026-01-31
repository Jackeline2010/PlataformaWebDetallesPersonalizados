<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Vista de perfil del administrador
     */
    public function perfil()
    {
        return view('admin.profile.index');
    }

    /**
     * Actualizar perfil
     */
    public function actualizar(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('photo')) {

            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $user->photo = $request->file('photo')->store('profiles', 'public');
        }

        $user->save();

        return back()->with('success', 'Perfil actualizado correctamente');
    }

    /**
     * Configuración (usa la vista que YA EXISTE)
     */
    public function configuracion()
    {
        return view('admin.settings.parameters');
    }

    /**
     * Mensajes (por ahora redirige a clientes o crea la vista luego)
     */
    public function mensajes()
    {
        return view('admin.customers.customers');
    }
}
