@extends('layouts.admin')
@section('title','Editar Producto')

@section('content')
@php
    $currentTipo = old('tipo_producto', $product->category_id);
    $currentOcasion = old('ocasion_especial', $selectedOcasion[0] ?? null);
    $sku = $product->sku ?? '';
@endphp

<div class="max-w-5xl mx-auto">

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
              enctype="multipart/form-data"
              class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- NOMBRE --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre del producto *</label>
                    <input
                        name="nombre"
                        value="{{ old('nombre', $product->nombre) }}"
                        class="w-full rounded-xl border border-pink-200 px-4 py-3"
                        required
                    >
                </div>

                {{-- SKU --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">SKU</label>
                    <input
                        value="{{ $sku }}"
                        readonly
                        class="w-full rounded-xl border bg-gray-50 px-4 py-3 text-gray-600"
                    >
                </div>

                {{-- IMAGEN --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Imagen del producto</label>

                    <div class="flex gap-4">
                        <div class="w-28 h-28 rounded-2xl border bg-pink-50 flex items-center justify-center overflow-hidden">
                            @if($product->imagen_principal)
                                <img id="imgPreviewEdit"
                                     src="{{ asset('storage/'.$product->imagen_principal) }}"
                                     class="w-full h-full object-cover">
                            @else
                                <img id="imgPreviewEdit" class="hidden w-full h-full object-cover">
                            @endif
                        </div>

                        <input type="file" name="imagen_principal" class="w-full border rounded-xl p-3">
                    </div>
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
                            value="{{ old('precio', $product->precio) }}"
                            class="w-full pl-9 rounded-xl border px-4 py-3"
                            required
                        >
                    </div>
                </div>

                {{-- COSTO FOTO IMPRESA --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Costo foto impresa
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">$</span>
                        <input
                            name="photo_print_price"
                            type="number"
                            step="0.01"
                            min="0"
                            value="{{ old('photo_print_price', $product->photo_print_price ?? 0) }}"
                            class="w-full pl-9 rounded-xl border px-4 py-3"
                        >
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Solo se cobrará si el cliente agrega una foto.
                    </p>
                </div>

                {{-- STOCK --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Stock</label>
                    <input
                        name="stock"
                        type="number"
                        value="{{ old('stock', $product->stock) }}"
                        class="w-full rounded-xl border px-4 py-3"
                    >
                </div>

                {{-- DESCRIPCIÓN --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Descripción corta</label>
                    <input
                        name="descripcion_corta"
                        value="{{ old('descripcion_corta', $product->descripcion_corta) }}"
                        class="w-full rounded-xl border px-4 py-3"
                    >
                </div>

                {{-- CATEGORÍAS --}}
                <div>
                    <label class="text-sm">Tipo producto</label>
                    <select name="tipo_producto" class="w-full border rounded-xl p-3">
                        @foreach($catsTipoProducto as $c)
                            <option value="{{ $c->id }}" {{ $currentTipo == $c->id ? 'selected' : '' }}>
                                {{ $c->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-sm">Ocasión</label>
                    <select name="ocasion_especial" class="w-full border rounded-xl p-3">
                        @foreach($catsOcasion as $c)
                            <option value="{{ $c->id }}" {{ $currentOcasion == $c->id ? 'selected' : '' }}>
                                {{ $c->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- PERSONALIZABLE --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold">Personalizable</label>
                    <select name="personalizable" class="w-full border rounded-xl p-3">
                        <option value="1" {{ $product->personalizable ? 'selected' : '' }}>Sí</option>
                        <option value="0" {{ !$product->personalizable ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                {{-- ESTADO --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold">Estado</label>
                    <select name="activo" class="w-full border rounded-xl p-3">
                        <option value="1" {{ $product->activo ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ !$product->activo ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

            </div>

            {{-- BOTONES --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.products.index') }}"
                   class="px-4 py-2 border rounded-xl">
                    Cancelar
                </a>

                <button type="submit"
                        class="px-6 py-2 bg-pink-500 text-white rounded-xl">
                    Guardar cambios
                </button>
            </div>

        </form>

    </div>
</div>
@endsection
