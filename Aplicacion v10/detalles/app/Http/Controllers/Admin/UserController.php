<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $role = $request->get('role'); // admin | cliente | null
        $status = $request->get('status'); // activo | inactivo | null

        $users = User::query()
            ->when($role, fn ($query) => $query->where('role', $role))
            ->when($status, function ($query) use ($status) {
                $query->where('activo', $status === 'activo');
            })
            ->when($q, function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%{$q}%")
                       ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'q', 'role', 'status'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'role' => ['required', Rule::in(['admin','cliente'])],
            'activo' => ['required', Rule::in(['1','0'])],
            'password' => ['required','string','min:8','confirmed'],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'activo' => (bool) $data['activo'],
            'password' => bcrypt($data['password']),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255', Rule::unique('users','email')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin','cliente'])],
            'activo' => ['required', Rule::in(['1','0'])],
            'password' => ['nullable','string','min:8','confirmed'],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = $data['role'];
        $user->activo = (bool) $data['activo'];

        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    // ✅ Activo/Inactivo (sin eliminar)
    public function toggle(User $user)
    {
        // Evitar que el admin se desactive a sí mismo (opcional pero recomendado)
        if (auth()->id() === $user->id) {
            return back()->with('error', 'No puedes desactivar tu propio usuario.');
        }

        $user->activo = !$user->activo;
        $user->save();

        return back()->with('success', 'Estado actualizado correctamente.');
    }
}
