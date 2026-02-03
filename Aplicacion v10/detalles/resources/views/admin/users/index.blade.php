@extends('layouts.admin')
@section('content')
<style>
    .sd-card{background:#fff;border-radius:16px;padding:16px;box-shadow:0 8px 20px rgba(0,0,0,.06)}
    .sd-title{font-size:26px;font-weight:800;color:#f05aa6;margin:0}
    .sd-muted{color:#6b7280}
    .sd-btn{border-radius:12px;padding:10px 14px;font-weight:700;border:1px solid #eee;background:#fff;cursor:pointer}
    .sd-btn-primary{background:#f05aa6;border-color:#f05aa6;color:#fff}
    .sd-btn-danger{background:#ef4444;border-color:#ef4444;color:#fff}
    .sd-input,.sd-select{border:1px solid #eee;border-radius:12px;padding:10px 12px;outline:none;width:100%}
    .sd-input:focus,.sd-select:focus{border-color:#f6a5cb;box-shadow:0 0 0 4px rgba(240,90,166,.15)}
    .sd-table{width:100%;border-collapse:separate;border-spacing:0 10px}
    .sd-row{background:#fff;border:1px solid #f3f4f6}
    .sd-row td{padding:12px 14px}
    .sd-row td:first-child{border-top-left-radius:14px;border-bottom-left-radius:14px}
    .sd-row td:last-child{border-top-right-radius:14px;border-bottom-right-radius:14px}
    .sd-badge{font-size:12px;font-weight:800;padding:6px 10px;border-radius:999px;display:inline-block}
    .badge-admin{background:#ede9fe;color:#6d28d9}
    .badge-cliente{background:#dbeafe;color:#1d4ed8}
    .badge-activo{background:#dcfce7;color:#166534}
    .badge-inactivo{background:#fee2e2;color:#991b1b}
</style>

<div class="p-4">
    <div class="flex items-center justify-between" style="margin-bottom:14px;">
        <div>
            <h1 class="sd-title">Usuarios</h1>
            <div class="sd-muted">Administra clientes y administradores (sin eliminar).</div>
        </div>

        <a class="sd-btn sd-btn-primary" href="{{ route('admin.users.create') }}">+ Nuevo usuario</a>
    </div>

    @if(session('success'))
        <div class="sd-card" style="border-left:6px solid #22c55e; margin-bottom:12px;">
            <strong>OK:</strong> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="sd-card" style="border-left:6px solid #ef4444; margin-bottom:12px;">
            <strong>Error:</strong> {{ session('error') }}
        </div>
    @endif

    <div class="sd-card" style="margin-bottom:14px;">
        <form method="GET" action="{{ route('admin.users.index') }}">
            <div style="display:grid;grid-template-columns: 2fr 1fr 1fr auto;gap:10px;align-items:end">
                <div>
                    <label class="sd-muted" style="font-size:12px;font-weight:700;">Buscar</label>
                    <input class="sd-input" type="text" name="q" value="{{ $q ?? '' }}" placeholder="Nombre o email...">
                </div>

                <div>
                    <label class="sd-muted" style="font-size:12px;font-weight:700;">Rol</label>
                    <select class="sd-select" name="role">
                        <option value="">Todos</option>
                        <option value="cliente" @selected(($role ?? '')==='cliente')>Cliente</option>
                        <option value="admin" @selected(($role ?? '')==='admin')>Admin</option>
                    </select>
                </div>

                <div>
                    <label class="sd-muted" style="font-size:12px;font-weight:700;">Estado</label>
                    <select class="sd-select" name="status">
                        <option value="">Todos</option>
                        <option value="activo" @selected(($status ?? '')==='activo')>Activo</option>
                        <option value="inactivo" @selected(($status ?? '')==='inactivo')>Inactivo</option>
                    </select>
                </div>

                <div style="display:flex;gap:8px;">
                    <button class="sd-btn sd-btn-primary" type="submit">Filtrar</button>
                    <a class="sd-btn" href="{{ route('admin.users.index') }}">Limpiar</a>
                </div>
            </div>
        </form>
    </div>

    <table class="sd-table">
        <thead>
            <tr class="sd-muted" style="font-size:12px;text-transform:uppercase;letter-spacing:.06em">
                <th style="text-align:left;padding:0 10px;">ID</th>
                <th style="text-align:left;padding:0 10px;">Nombre</th>
                <th style="text-align:left;padding:0 10px;">Email</th>
                <th style="text-align:left;padding:0 10px;">Rol</th>
                <th style="text-align:left;padding:0 10px;">Estado</th>
                <th style="text-align:right;padding:0 10px;">Acciones</th>
            </tr>
        </thead>

        <tbody>
        @forelse($users as $u)
            <tr class="sd-row">
                <td>{{ $u->id }}</td>
                <td style="font-weight:800">{{ $u->name }}</td>
                <td class="sd-muted">{{ $u->email }}</td>
                <td>
                    <span class="sd-badge {{ $u->role==='admin' ? 'badge-admin' : 'badge-cliente' }}">
                        {{ $u->role==='admin' ? 'ADMIN' : 'CLIENTE' }}
                    </span>
                </td>
                <td>
                    <span class="sd-badge {{ $u->activo ? 'badge-activo' : 'badge-inactivo' }}">
                        {{ $u->activo ? 'ACTIVO' : 'INACTIVO' }}
                    </span>
                </td>
                <td style="text-align:right;">
                    <div style="display:inline-flex;gap:8px;align-items:center;">
                        <a class="sd-btn" href="{{ route('admin.users.edit', $u) }}">Editar</a>

                        <form method="POST" action="{{ route('admin.users.toggle', $u) }}">
                            @csrf
                            @method('PATCH')
                            <button class="sd-btn {{ $u->activo ? 'sd-btn-danger' : 'sd-btn-primary' }}" type="submit">
                                {{ $u->activo ? 'Desactivar' : 'Activar' }}
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="sd-card">No hay usuarios.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:14px;">
        {{ $users->links() }}
    </div>
</div>
@endsection
