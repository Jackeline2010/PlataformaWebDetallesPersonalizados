@extends('layouts.admin')
@section('title', 'Nuevo Extra')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Nuevo Extra</h1>

        <form action="{{ route('admin.extras.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}"
                       class="w-full rounded-xl border border-pink-200 px-4 py-3 focus:ring-2 focus:ring-pink-200">
                @error('nombre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                <input type="text" name="tipo" value="{{ old('tipo') }}"
                       class="w-full rounded-xl border border-pink-200 px-4 py-3 focus:ring-2 focus:ring-pink-200">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="descripcion" rows="4"
                          class="w-full rounded-xl border border-pink-200 px-4 py-3 focus:ring-2 focus:ring-pink-200">{{ old('descripcion') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Precio adicional</label>
                <input type="number" step="0.01" min="0" name="precio_adicional" value="{{ old('precio_adicional') }}"
                       class="w-full rounded-xl border border-pink-200 px-4 py-3 focus:ring-2 focus:ring-pink-200">
                @error('precio_adicional') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Imagen</label>
                <input type="file" name="imagen" accept="image/*"
                       class="w-full rounded-xl border border-pink-200 px-4 py-3 bg-white">
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="activo" id="activo" value="1" checked>
                <label for="activo" class="text-sm text-gray-700">Activo</label>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('admin.extras.index') }}"
                   class="px-4 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50">
                    Cancelar
                </a>

                <button type="submit"
                        class="px-5 py-2 rounded-xl bg-pink-600 text-white hover:bg-pink-700">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
