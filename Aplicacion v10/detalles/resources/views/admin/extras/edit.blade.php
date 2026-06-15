@extends('layouts.admin')
@section('title', 'Editar Extra')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Extra</h1>

        @if($errors->any())
            <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.extras.update', $extra) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre', $extra->nombre) }}"
                       class="w-full rounded-xl border border-pink-200 px-4 py-3 focus:ring-2 focus:ring-pink-200"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                <input type="text" name="tipo" value="{{ old('tipo', $extra->tipo) }}"
                       placeholder="Ejemplo: globo, peluche, chocolate, vino"
                       class="w-full rounded-xl border border-pink-200 px-4 py-3 focus:ring-2 focus:ring-pink-200">
                <p class="text-xs text-gray-500 mt-1">
                    El tipo ayuda al sistema a clasificar el extra.
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="descripcion" rows="4"
                          class="w-full rounded-xl border border-pink-200 px-4 py-3 focus:ring-2 focus:ring-pink-200">{{ old('descripcion', $extra->descripcion) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Precio adicional</label>
                <input type="number" step="0.01" min="0" name="precio_adicional"
                       value="{{ old('precio_adicional', $extra->precio_adicional) }}"
                       class="w-full rounded-xl border border-pink-200 px-4 py-3 focus:ring-2 focus:ring-pink-200"
                       required>
            </div>

            <div class="bg-pink-50 border border-pink-100 rounded-2xl p-5 space-y-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Inventario del extra</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Estos datos permiten controlar el stock de globos, chocolates, peluches y demás complementos.
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Código SKU
                    </label>

                    <input
                        type="text"
                        value="{{ $extra->sku }}"
                        readonly
                        class="w-full rounded-xl border border-gray-200 bg-gray-100 px-4 py-3 text-gray-600"
                    >

                    <p class="text-xs text-gray-500 mt-1">
                        Este código es generado automáticamente por el sistema y no puede modificarse.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stock actual</label>
                        <input type="number"
                               min="0"
                               name="stock"
                               value="{{ old('stock', $extra->stock ?? 0) }}"
                               class="w-full rounded-xl border border-pink-200 px-4 py-3 focus:ring-2 focus:ring-pink-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stock mínimo</label>
                        <input type="number"
                               min="0"
                               name="stock_minimo"
                               value="{{ old('stock_minimo', $extra->stock_minimo ?? 0) }}"
                               class="w-full rounded-xl border border-pink-200 px-4 py-3 focus:ring-2 focus:ring-pink-200">
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox"
                           name="controla_stock"
                           id="controla_stock"
                           value="1"
                           {{ old('controla_stock', $extra->controla_stock) ? 'checked' : '' }}>
                    <label for="controla_stock" class="text-sm text-gray-700">
                        Controlar stock de este extra
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Imagen</label>
                <input type="file" name="imagen" accept="image/*"
                       class="w-full rounded-xl border border-pink-200 px-4 py-3 bg-white">

                @if($extra->imagen)
                    <div class="mt-3">
                        <p class="text-xs text-gray-500 mb-2">Imagen actual:</p>
                        <img
                            src="{{ asset('storage/' . $extra->imagen) }}"
                            alt="{{ $extra->nombre }}"
                            class="w-24 h-24 object-cover rounded-xl border border-pink-100">
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox"
                       name="activo"
                       id="activo"
                       value="1"
                       {{ old('activo', $extra->activo) ? 'checked' : '' }}>
                <label for="activo" class="text-sm text-gray-700">Activo</label>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('admin.extras.index') }}"
                   class="px-4 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50">
                    Cancelar
                </a>

                <button type="submit"
                        class="px-5 py-2 rounded-xl bg-pink-600 text-white hover:bg-pink-700">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
