<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
     {
        $user = Auth::user();

        // 1) Buscar cliente por user_id (si existe)
        $client = Client::where('user_id', $user->id)->first();

        // 2) Fallback: si NO hay por user_id, buscar por email (muy común)
        if (!$client && $user->email) {
            $client = Client::where('email', $user->email)->first();
        }

        // Órdenes (ajusta según tu BD: user_id o client_id)
        $orders = Order::query()
            ->when($user?->id, fn($q) => $q->where('user_id', $user->id))
            ->latest()
            ->take(5)
            ->get();

        return view('client.profile', compact('user', 'client', 'orders'));
    }

        public function update(Request $request)
{
    $user = Auth::user();

    $data = $request->validate([
        'identificacion' => ['nullable','string','max:255'],
        'nombres'        => ['required','string','max:255'],
        'apellidos'      => ['required','string','max:255'],
        'email'          => ['required','email','max:255'],
        'telefono'       => ['nullable','string','max:255'],
        'fnacimiento'    => ['nullable','date'],
        'genero'         => ['nullable','in:M,F,O'],
    ]);

    // ✅ Evitar que vuelva a entrar "GUEST" por defecto en identificacion
    // (si lo dejan vacío, mejor NO tocar el campo)
    if (empty($data['identificacion'])) {
        unset($data['identificacion']);
    }

    // Campos requeridos/útiles
    $data['user_id']  = $user->id;

    // Si no existe aún, se creará con estos defaults
    $data['activo']   = true;
    $data['fingreso'] = now()->toDateString();

    // ✅ Actualiza o crea por user_id (solo 1 registro por usuario)
    Client::updateOrCreate(
        ['user_id' => $user->id],
        $data
    );

    // (opcional) sincronizar email del usuario
    if (!empty($data['email']) && $user->email !== $data['email']) {
        $user->email = $data['email'];
        $user->save();
    }

    return redirect()->route('client.profile')->with('success', 'Perfil actualizado.');
}

}


