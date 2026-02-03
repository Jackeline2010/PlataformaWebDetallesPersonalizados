@extends('layouts.admin')

@section('content')
<div class="container">

<h2>Crear usuario</h2>

<form method="POST" action="{{ route('admin.users.store') }}">
@csrf

<div style="margin-bottom:12px">
    <input name="name" placeholder="Nombre" required style="width:300px">
</div>

<div style="margin-bottom:12px">
    <input name="email" type="email" placeholder="Email" required style="width:300px">
</div>

<div style="margin-bottom:12px">
    <label>Rol</label><br>
    <select name="role" required style="width:300px">
        <option value="cliente">Cliente</option>
        <option value="admin">Admin</option>
    </select>
</div>

{{-- ✅ NUEVO: ACTIVO / INACTIVO --}}
<div style="margin-bottom:12px">
    <label>Estado</label><br>
    <select name="activo" required style="width:300px">
        <option value="1">Activo</option>
        <option value="0">Inactivo</option>
    </select>
</div>

<div style="margin-bottom:12px">
    <input type="password" name="password" placeholder="Password" required style="width:300px">
</div>

<div style="margin-bottom:12px">
    <input type="password" name="password_confirmation" placeholder="Confirmar password" required style="width:300px">
</div>

<div style="display:flex; gap:10px; margin-top:15px">
    <button type="submit">Guardar</button>

    <a href="{{ route('admin.users.index') }}">Cancelar</a>
</div>

</form>

</div>
@endsection
