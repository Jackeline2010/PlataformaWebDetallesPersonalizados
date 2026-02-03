@extends('layouts.admin')

@section('content')
<div class="container">

<h2>Editar usuario</h2>

<form method="POST" action="{{ route('admin.users.update',$user) }}">
@csrf
@method('PUT')

<div style="margin-bottom:12px">
    <input name="name" value="{{ $user->name }}" required style="width:300px">
</div>

<div style="margin-bottom:12px">
    <input name="email" value="{{ $user->email }}" required style="width:300px">
</div>

<div style="margin-bottom:12px">
    <label>Rol</label><br>
    <select name="role" required style="width:300px">
        <option value="cliente" {{ $user->role=='cliente'?'selected':'' }}>Cliente</option>
        <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
    </select>
</div>

{{-- ✅ NUEVO: ACTIVO / INACTIVO --}}
<div style="margin-bottom:12px">
    <label>Estado</label><br>
    <select name="activo" required style="width:300px">
        <option value="1" {{ $user->activo ? 'selected' : '' }}>Activo</option>
        <option value="0" {{ !$user->activo ? 'selected' : '' }}>Inactivo</option>
    </select>
</div>

<hr style="margin:20px 0">

<div style="margin-bottom:12px">
    <input type="password" name="password" placeholder="Nuevo password (opcional)" style="width:300px">
</div>

<div style="margin-bottom:12px">
    <input type="password" name="password_confirmation" placeholder="Confirmar password" style="width:300px">
</div>

<div style="display:flex; gap:10px; margin-top:15px">
    <button type="submit">Actualizar</button>

    <a href="{{ route('admin.users.index') }}">Cancelar</a>
</div>

</form>

</div>
@endsection

