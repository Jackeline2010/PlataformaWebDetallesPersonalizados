@extends('layouts.admin')
@section('title','Editar Producto')

@section('content')
@php
    // Selección actual (principal)
    $currentTipo = old('tipo_producto', $product->category_id);

    // Pivot seleccionados (llegan desde el controller: $selectedOcasion, $selectedPersonal)
    $currentOcasion  = old('ocasion_especial', $selectedOcasion[0] ?? null);
    $currentPersonal = old('tipo_personalizacion', $selectedPersonal[0] ?? null);

    // SKU solo para mostrar
    $sku = $product->sku ?? '';
@endphp

<div class="max-w-4xl mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-pink-500">Editar Producto</h1>
        <p class="text-sm text-gray-500">Actualiza la información del producto y guarda los cambios.</p>
    </div>

    <div class="bg-white rounded-2xl shadow p-6 md:p-8 border border-pink-100">

        {{-- ERRORES --}}
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-700">
                <p class="font-semibold mb-2">Revisa estos campos:</p>
                <ul class="list-disc ml-5 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="productEditForm"
              method="POST"
              action="{{ route('admin.products.update', $product) }}"
              class="space-y-6"
              autocomplete="off">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- NOMBRE --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre del producto *</label>
                    <input
                        name="nombre"
                        value="{{ old('nombre', $product->nombre) }}"
                        class="w-full rounded-xl border border-pink-200 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-300"
                        required
                    >
                    @error('nombre')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- SKU (solo lectura) --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">SKU</label>
                    <input
                        value="{{ $sku }}"
                        readonly
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-600"
                        placeholder="Se genera automáticamente"
                    >
                    <p class="mt-1 text-xs text-gray-500">El SKU se genera automáticamente y no se edita.</p>
                </div>

                {{-- PRECIO --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Precio *</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">$</span>
                        <input
                            name="precio"
                            type="number"
                            step="0.01"
                            min="0"
                            value="{{ old('precio', $product->precio) }}"
                            class="w-full pl-9 rounded-xl border border-pink-200 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-300"
                            required
                        >
                    </div>
                    @error('precio')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- STOCK --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Stock</label>
                    <input
                        name="stock"
                        type="number"
                        min="0"
                        value="{{ old('stock', $product->stock ?? 0) }}"
                        class="w-full rounded-xl border border-pink-200 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-300"
                    >
                    @error('stock')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- DESCRIPCIÓN CORTA --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Descripción corta</label>
                    <input
                        name="descripcion_corta"
                        value="{{ old('descripcion_corta', $product->descripcion_corta) }}"
                        class="w-full rounded-xl border border-pink-200 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-300"
                    >
                    @error('descripcion_corta')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- CATEGORÍAS (3 SELECTS) --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Categorías</label>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Tipo de producto *</label>
                            <select id="tipo_producto"
                                    name="tipo_producto"
                                    class="w-full rounded-xl border border-pink-200 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-300"
                                    required>
                                <option value="">Selecciona un tipo...</option>
                                @foreach($catsTipoProducto as $c)
                                    <option value="{{ $c->id }}" {{ (string)$currentTipo === (string)$c->id ? 'selected' : '' }}>
                                        {{ $c->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo_producto')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Ocasión especial</label>
                            <select id="ocasion_especial"
                                    name="ocasion_especial"
                                    class="w-full rounded-xl border border-pink-200 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-300">
                                <option value="">Selecciona una ocasión...</option>
                                @foreach($catsOcasion as $c)
                                    <option value="{{ $c->id }}" {{ (string)$currentOcasion === (string)$c->id ? 'selected' : '' }}>
                                        {{ $c->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ocasion_especial')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Tipo de personalización</label>
                            <select id="tipo_personalizacion"
                                    name="tipo_personalizacion"
                                    class="w-full rounded-xl border border-pink-200 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-300">
                                <option value="">Selecciona un tipo...</option>
                                @foreach($catsPersonal as $c)
                                    <option value="{{ $c->id }}" {{ (string)$currentPersonal === (string)$c->id ? 'selected' : '' }}>
                                        {{ $c->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo_personalizacion')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- PERSONALIZABLE --}}
                <div class="md:col-span-2 p-5 rounded-2xl border border-pink-100 bg-white shadow-sm">
                    <p class="text-sm font-semibold text-gray-700 mb-2">Personalizable</p>

                    <div class="flex gap-3">
                        <label class="flex-1">
                            <input type="radio" name="personalizable" value="1" class="peer hidden"
                                   {{ old('personalizable', (int)($product->personalizable ?? 0)) == 1 ? 'checked' : '' }}>
                            <div class="w-full text-center px-4 py-2 rounded-xl border border-pink-200
                                        peer-checked:bg-pink-500 peer-checked:text-white peer-checked:border-pink-500 cursor-pointer">
                                Sí
                            </div>
                        </label>

                        <label class="flex-1">
                            <input type="radio" name="personalizable" value="0" class="peer hidden"
                                   {{ old('personalizable', (int)($product->personalizable ?? 0)) == 0 ? 'checked' : '' }}>
                            <div class="w-full text-center px-4 py-2 rounded-xl border border-pink-200
                                        peer-checked:bg-pink-500 peer-checked:text-white peer-checked:border-pink-500 cursor-pointer">
                                No
                            </div>
                        </label>
                    </div>

                    @error('personalizable')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ESTADO (Activo/Inactivo) --}}
                <div class="md:col-span-2 p-5 rounded-2xl border border-pink-100 bg-white shadow-sm">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Estado</label>
                    <select name="activo"
                            class="w-full rounded-xl border border-pink-200 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-300">
                        <option value="1" {{ old('activo', (int)($product->activo ?? 1)) == 1 ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ old('activo', (int)($product->activo ?? 1)) == 0 ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('activo')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- BOTONES --}}
            <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
                <a href="{{ route('admin.products.index') }}"
                   class="px-5 py-3 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 text-center">
                    Cancelar
                </a>

                {{-- ✅ Botón con modal --}}
               <button type="button"
            data-confirm-submit="productEditForm"
            data-confirm-title="Confirmar edición"
            data-confirm-message="¿Está seguro que desea guardar los cambios del producto: {{ e($product->nombre) }}?"
            data-confirm-ok="Sí, guardar"
            data-confirm-cancel="Cancelar"
             class="px-6 py-3 rounded-xl bg-pink-500 text-white font-semibold hover:bg-pink-600 shadow-sm">
          Guardar cambios
        </button>
            </div>

        </form>
    </div>
</div>
@endsection
