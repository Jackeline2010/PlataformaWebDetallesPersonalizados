@extends('layouts.admin')

@section('title', 'Perfil Administrador')

@section('content')
<div class="p-6 max-w-4xl mx-auto">

    <!-- BOTÓN INICIO -->
    <a href="{{ route('admin.dashboard') }}"
       class="inline-flex items-center gap-2 mb-6 px-4 py-2 rounded-xl
              bg-pink-100 text-pink-600 font-semibold hover:bg-pink-200 transition">
        <i class="fas fa-arrow-left"></i>
        Inicio
    </a>

    <h2 class="text-2xl font-bold text-pink-500 mb-6">Mi Perfil</h2>

    @if(session('success'))
        <div class="mb-4 p-3 rounded-xl bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow p-6">

        <form action="{{ route('admin.profile.update') }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6">

            @csrf


            <!-- FOTO DE PERFIL -->
  <!-- FOTO DE PERFIL -->
<div class="flex items-center gap-6">

    <div class="relative group">
        <label for="photo" class="cursor-pointer">

            <img
                id="previewImage"
                src="{{ Auth::user()->photo
                        ? asset('storage/' . Auth::user()->photo)
                        : asset('images/Avatar-admin.png') }}"
                class="w-24 h-24 rounded-full object-cover
                       border-4 border-pink-300 shadow-md
                       group-hover:opacity-80 transition"
                alt="Avatar administrador">

            <!-- ICONO EDITAR -->
            <div class="absolute bottom-1 right-1 bg-pink-500 text-white p-2 rounded-full shadow
                        opacity-0 group-hover:opacity-100 transition">
                <i class="fas fa-camera"></i>
            </div>

        </label>

        <input
            type="file"
            name="photo"
            id="photo"
            class="hidden"
            accept="image/*"
            onchange="previewPhoto(event)">
    </div>

    <span class="text-sm text-gray-500">
        Click en el avatar para cambiar la foto
    </span>

</div>

            <!-- NOMBRE -->
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">
                    Nombre
                </label>
                <input type="text"
                       name="name"
                       value="{{ Auth::user()->name }}"
                       required
                       class="w-full rounded-xl border-gray-300
                              focus:border-pink-400 focus:ring-pink-400">
            </div>

            <!-- EMAIL -->
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">
                    Email
                </label>
                <input type="email"
                       name="email"
                       value="{{ Auth::user()->email }}"
                       required
                       class="w-full rounded-xl border-gray-300
                              focus:border-pink-400 focus:ring-pink-400">
            </div>

            <!-- BOTÓN -->
            <div class="pt-4">
                <button type="submit"
                        class="px-6 py-2 rounded-xl
                               bg-pink-500 text-white font-semibold
                               hover:bg-pink-600 transition">
                    Guardar cambios
                </button>
            </div>

        </form>
    </div>
</div>

<!-- PREVIEW JS -->
<script>
function previewPhoto(event) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('previewImage').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
