<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $client = Client::where('user_id', $user->id)->first();

        if (!$client && $user->email) {
            $client = Client::where('email', $user->email)->first();

            if ($client && !$client->user_id) {
                $client->user_id = $user->id;
                $client->save();
            }
        }

        $orders = Order::query()
            ->where(function ($query) use ($user, $client) {
                $query->where('user_id', $user->id);

                if ($client) {
                    $query->orWhere('client_id', $client->id);
                }
            })
            ->latest()
            ->take(5)
            ->get();

        return view('client.profile', compact('user', 'client', 'orders'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'identificacion' => ['nullable', 'string', 'max:255'],
            'nombres'        => ['required', 'string', 'max:255'],
            'apellidos'      => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email', 'max:255'],
            'telefono'       => ['nullable', 'string', 'max:255'],
            'direccion'      => ['nullable', 'string', 'max:500'],
            'fnacimiento'    => ['nullable', 'date'],
            'genero'         => ['nullable', 'in:M,F,O'],
        ]);

        if (empty($data['identificacion'])) {
            unset($data['identificacion']);
        }

        $data['user_id'] = $user->id;
        $data['activo'] = true;

        $client = Client::where('user_id', $user->id)->first();

        if (!$client && $user->email) {
            $client = Client::where('email', $user->email)->first();
        }

        if ($client) {
            $client->update($data);
        } else {
            $data['fingreso'] = now()->toDateString();
            Client::create($data);
        }

        if (!empty($data['email']) && $user->email !== $data['email']) {
            $user->email = $data['email'];
            $user->save();
        }

        return redirect()
            ->route('client.profile')
            ->with('success', 'Perfil actualizado correctamente.');
    }
}
