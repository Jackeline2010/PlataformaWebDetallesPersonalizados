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
                        class="w-full rounded-xl border border-pink-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-300"
                        required
                    >
                    @error('nombre')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
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

                        <div class="flex-1">
                            <input
                                id="imagen_principal_edit"
                                type="file"
                                name="imagen_principal"
                                accept="image/*"
                                class="w-full border border-pink-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-pink-300"
                            >
                            <p class="text-xs text-gray-500 mt-2">
                                Si subes una nueva imagen, reemplazará la imagen actual.
                            </p>
                        </div>
                    </div>

                    @error('imagen_principal')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
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
                            class="w-full pl-9 rounded-xl border border-pink-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-300"
                            required
                        >
                    </div>
                    @error('precio')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
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
                            class="w-full pl-9 rounded-xl border border-pink-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-300"
                        >
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Solo se cobrará si el cliente agrega una foto.
                    </p>
                    @error('photo_print_price')
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
                        value="{{ old('stock', $product->stock) }}"
                        class="w-full rounded-xl border border-pink-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-300"
                    >
                    @error('stock')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- DESCRIPCIÓN --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Descripción corta</label>
                    <input
                        name="descripcion_corta"
                        value="{{ old('descripcion_corta', $product->descripcion_corta) }}"
                        class="w-full rounded-xl border border-pink-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-300"
                    >
                    @error('descripcion_corta')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- CATEGORÍAS --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tipo producto</label>
                    <select name="tipo_producto"
                            class="w-full border border-pink-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-pink-300">
                        <option value="">Selecciona un tipo...</option>
                        @foreach($catsTipoProducto as $c)
                            <option value="{{ $c->id }}" {{ $currentTipo == $c->id ? 'selected' : '' }}>
                                {{ $c->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('tipo_producto')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Ocasión</label>
                    <select name="ocasion_especial"
                            class="w-full border border-pink-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-pink-300">
                        <option value="">Sin ocasión especial</option>
                        @foreach($catsOcasion as $c)
                            <option value="{{ $c->id }}" {{ $currentOcasion == $c->id ? 'selected' : '' }}>
                                {{ $c->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('ocasion_especial')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- CONFIGURACIÓN DE VISTA PREVIA --}}
                <div class="md:col-span-2">
                    <div class="p-5 rounded-2xl border border-pink-100 bg-pink-50/40">
                        <div class="mb-4">
                            <h3 class="text-sm font-bold text-gray-800">
                                Configuración de vista previa
                            </h3>
                            <p class="text-xs text-gray-500 mt-1">
                                Define cómo se ubicará la foto, los extras y la dedicatoria en el editor del cliente.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            {{-- TIPO DE ARREGLO --}}
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">
                                    Tipo de arreglo
                                </label>
                                <select
                                    name="tipo_arreglo"
                                    class="w-full rounded-xl border border-pink-200 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-300"
                                >
                                    <option value="">Selecciona...</option>
                                    <option value="bouquet" {{ old('tipo_arreglo', $product->tipo_arreglo) == 'bouquet' ? 'selected' : '' }}>Bouquet</option>
                                    <option value="corazon" {{ old('tipo_arreglo', $product->tipo_arreglo) == 'corazon' ? 'selected' : '' }}>Caja corazón</option>
                                    <option value="redondo" {{ old('tipo_arreglo', $product->tipo_arreglo) == 'redondo' ? 'selected' : '' }}>Caja redonda</option>
                                    <option value="cuadrado" {{ old('tipo_arreglo', $product->tipo_arreglo) == 'cuadrado' ? 'selected' : '' }}>Caja cuadrada</option>
                                    <option value="peluche" {{ old('tipo_arreglo', $product->tipo_arreglo) == 'peluche' ? 'selected' : '' }}>Arreglo con peluche</option>
                                    <option value="caja_sorpresa" {{ old('tipo_arreglo', $product->tipo_arreglo) == 'caja_sorpresa' ? 'selected' : '' }}>Caja sorpresa</option>
                                    <option value="globos" {{ old('tipo_arreglo', $product->tipo_arreglo) == 'globos' ? 'selected' : '' }}>Arreglo con globos</option>
                                </select>

                                @error('tipo_arreglo')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                          {{-- PLANTILLA VISUAL --}}
<div>
    <label class="block text-xs font-semibold text-gray-600 mb-1">
        Distribución del diseño
    </label>
    <select
        name="plantilla_preview"
        class="w-full rounded-xl border border-pink-200 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-300"
    >
        <option value="">Selecciona...</option>
        <option value="bouquet_right" {{ old('plantilla_preview', $product->plantilla_preview) == 'bouquet_right' ? 'selected' : '' }}>
            Foto a la derecha + dedicatoria en base
        </option>
        <option value="bouquet_left" {{ old('plantilla_preview', $product->plantilla_preview) == 'bouquet_left' ? 'selected' : '' }}>
            Foto a la izquierda + dedicatoria en base
        </option>
        <option value="balloon_top" {{ old('plantilla_preview', $product->plantilla_preview) == 'balloon_top' ? 'selected' : '' }}>
            Foto central + extras en parte baja
        </option>
        <option value="heart_center" {{ old('plantilla_preview', $product->plantilla_preview) == 'heart_center' ? 'selected' : '' }}>
            Foto centrada + dedicatoria en base
        </option>
        <option value="round_top" {{ old('plantilla_preview', $product->plantilla_preview) == 'round_top' ? 'selected' : '' }}>
            Foto arriba + extras alrededor
        </option>
        <option value="photo_top_extras_top" {{ old('plantilla_preview', $product->plantilla_preview) == 'photo_top_extras_top' ? 'selected' : '' }}>
            Foto arriba + extras arriba
        </option>
        <option value="teddy_center" {{ old('plantilla_preview', $product->plantilla_preview) == 'teddy_center' ? 'selected' : '' }}>
            Foto lateral + extras sin cubrir peluche
        </option>
        <option value="box_center" {{ old('plantilla_preview', $product->plantilla_preview) == 'box_center' ? 'selected' : '' }}>
            Foto lateral + extras centrales
        </option>
        <option value="free_layout" {{ old('plantilla_preview', $product->plantilla_preview) == 'free_layout' ? 'selected' : '' }}>
            Distribución libre
        </option>
    </select>

    @error('plantilla_preview')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
        </div>

</div>
               <p class="mt-3 text-xs text-gray-500">
                         Elige la distribución que mejor se adapte al diseño del producto. Esto ayuda a ubicar mejor la foto, los extras y la dedicatoria.
              </p>
                    </div>
                </div>

                {{-- PERSONALIZABLE --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Personalizable</label>
                    <select name="personalizable"
                            class="w-full border border-pink-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-pink-300">
                        <option value="1" {{ old('personalizable', $product->personalizable) == 1 ? 'selected' : '' }}>Sí</option>
                        <option value="0" {{ old('personalizable', $product->personalizable) == 0 ? 'selected' : '' }}>No</option>
                    </select>
                    @error('personalizable')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- VARIANTES PRODUCTO --}}
                <div class="md:col-span-2">
                    <div class="p-5 rounded-2xl border border-pink-100 bg-white shadow-sm">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            ¿Deseas agregar colores para este producto?
                        </label>

                        <p class="text-xs text-gray-500 mb-3">
                            Este campo es opcional. Si eliges “Sí”, podrás registrar colores disponibles para este producto.
                        </p>

                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input
                                    type="radio"
                                    name="tiene_variantes"
                                    value="1"
                                    {{ old('tiene_variantes', $product->tiene_variantes) == 1 ? 'checked' : '' }}
                                    class="text-pink-600 focus:ring-pink-500 border-gray-300">
                                <span class="text-sm text-gray-700">Sí</span>
                            </label>

                            <label class="flex items-center gap-2 cursor-pointer">
                                <input
                                    type="radio"
                                    name="tiene_variantes"
                                    value="0"
                                    {{ old('tiene_variantes', $product->tiene_variantes) == 0 ? 'checked' : '' }}
                                    class="text-pink-600 focus:ring-pink-500 border-gray-300">
                                <span class="text-sm text-gray-700">No</span>
                            </label>
                        </div>

                        @error('tiene_variantes')
                            <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- ESTADO --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Estado</label>
                    <select name="activo"
                            class="w-full border border-pink-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-pink-300">
                        <option value="1" {{ old('activo', $product->activo) == 1 ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ old('activo', $product->activo) == 0 ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('activo')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const inputImg = document.getElementById('imagen_principal_edit');
        const imgPreview = document.getElementById('imgPreviewEdit');

        inputImg?.addEventListener('change', (e) => {
            const file = e.target.files?.[0];

            if (!file || !imgPreview) {
                return;
            }

            const url = URL.createObjectURL(file);
            imgPreview.src = url;
            imgPreview.classList.remove('hidden');
        });
    });
</script>
@endpush
