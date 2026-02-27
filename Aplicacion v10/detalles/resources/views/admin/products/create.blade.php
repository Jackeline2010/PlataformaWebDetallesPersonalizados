@extends('layouts.admin')
@section('title','Nuevo Producto')
@section('content')
<div class="max-w-6xl mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-pink-500">Nuevo Producto</h1>
        <p class="text-sm text-gray-500">Completa la información del producto y guarda los cambios.</p>
    </div>

    <div class="bg-white rounded-2xl shadow p-6 md:p-8 border border-pink-100">

        {{-- ERRORES GENERALES --}}
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

        {{-- ✅ AHORA CON enctype PARA IMÁGENES --}}
        <form id="productForm"
              action="{{ route('admin.products.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6">
            @csrf

            {{-- GRID PRINCIPAL --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                {{-- COLUMNA IZQUIERDA --}}
                <div class="lg:col-span-8 space-y-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- NOMBRE --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre del producto *</label>
                            <input
                                name="nombre"
                                value="{{ old('nombre') }}"
                                placeholder="Ej: Arreglo floral, Caja regalo, Vela aromática..."
                                class="w-full rounded-xl border border-pink-200 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-300"
                                required
                            >
                            @error('nombre')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ✅ SKU eliminado (se generará automático en backend) --}}

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
                                    value="{{ old('precio') }}"
                                    placeholder="0.00"
                                    class="w-full pl-9 rounded-xl border border-pink-200 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-300"
                                    required
                                >
                            </div>
                            @error('precio')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- DESCRIPCIÓN CORTA --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Descripción corta</label>
                            <input
                                name="descripcion_corta"
                                value="{{ old('descripcion_corta') }}"
                                placeholder="Ej: Arreglo con rosas y chocolates..."
                                class="w-full rounded-xl border border-pink-200 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-300"
                            >
                            @error('descripcion_corta')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ✅ IMAGEN PRINCIPAL --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Imagen del producto</label>

                            <div class="flex items-start gap-4">
                                {{-- Preview (vacío al inicio) --}}
                                <div class="w-28 h-28 rounded-2xl border border-pink-100 bg-pink-50/40 flex items-center justify-center overflow-hidden">
                                    <img id="imgPreview" src="" alt="Vista previa"
                                         class="hidden w-full h-full object-cover">
                                    <div id="imgPlaceholder" class="text-xs text-gray-400 text-center px-2">
                                        Sin imagen
                                    </div>
                                </div>

                                <div class="flex-1">
                                    <input
                                        id="imagen_principal"
                                        type="file"
                                        name="imagen_principal"
                                        accept="image/*"
                                        class="w-full rounded-xl border border-pink-200 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-300"
                                    >
                                    <p class="mt-2 text-xs text-gray-500">
                                        Formatos: JPG, PNG o WEBP. Tamaño recomendado: 1200x1200.
                                    </p>

                                    {{-- ✅ CORREGIDO: el error es imagen_principal --}}
                                    @error('imagen_principal')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- ✅ CATEGORÍAS (3 SELECTS) --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Categorías</label>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Tipo de producto</label>
                                    <select id="tipo_producto"
                                            name="tipo_producto"
                                            class="w-full rounded-xl border border-pink-200 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-300">
                                        <option value="">Selecciona un tipo...</option>
                                        @foreach($catsTipoProducto as $c)
                                            <option value="{{ $c->id }}" {{ old('tipo_producto') == $c->id ? 'selected' : '' }}>
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
                                            <option value="{{ $c->id }}" {{ old('ocasion_especial') == $c->id ? 'selected' : '' }}>
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
                                            <option value="{{ $c->id }}" {{ old('tipo_personalizacion') == $c->id ? 'selected' : '' }}>
                                                {{ $c->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tipo_personalizacion')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>

                            {{-- ✅ Hidden enviados como categories[] --}}
                            <input type="hidden" name="categories[]" id="cat_1" value="">
                            <input type="hidden" name="categories[]" id="cat_2" value="">
                            <input type="hidden" name="categories[]" id="cat_3" value="">
                            @error('categories')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- COLUMNA DERECHA --}}
                <div class="lg:col-span-4 space-y-6">

                    {{-- PERSONALIZABLE --}}
                    <div class="p-5 rounded-2xl border border-pink-100 bg-white shadow-sm">
                        <p class="text-sm font-semibold text-gray-700 mb-2">Personalizable</p>

                        <div class="flex gap-3">
                            <label class="flex-1">
                                <input type="radio" name="personalizable" value="1" class="peer hidden"
                                       {{ old('personalizable', 0) == 1 ? 'checked' : '' }}>
                                <div class="w-full text-center px-4 py-2 rounded-xl border border-pink-200
                                            peer-checked:bg-pink-500 peer-checked:text-white peer-checked:border-pink-500 cursor-pointer">
                                    Sí
                                </div>
                            </label>

                            <label class="flex-1">
                                <input type="radio" name="personalizable" value="0" class="peer hidden"
                                       {{ old('personalizable', 0) == 0 ? 'checked' : '' }}>
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

                    {{-- STOCK --}}
                    <div class="p-5 rounded-2xl border border-pink-100 bg-white shadow-sm">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Stock</label>
                        <input
                            name="stock"
                            type="number"
                            min="0"
                            value="{{ old('stock', 0) }}"
                            class="w-full rounded-xl border border-pink-200 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-300"
                        >
                        @error('stock')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ESTADO --}}
                    <div class="p-5 rounded-2xl border border-pink-100 bg-white shadow-sm">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Estado</label>
                        <select name="activo"
                                class="w-full rounded-xl border border-pink-200 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-300">
                            <option value="1" {{ old('activo', 1) == 1 ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('activo', 1) == 0 ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('activo')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- BOTONES --}}
                    <div class="flex flex-col gap-3">
                        <button type="button"
                                data-confirm-submit="productForm"
                                data-confirm-title="Confirmar guardado"
                                data-confirm-message="¿Está seguro que desea guardar este producto?"
                                data-confirm-ok="Sí, guardar"
                                data-confirm-cancel="Cancelar"
                                class="w-full px-6 py-3 rounded-xl bg-pink-500 text-white font-semibold hover:bg-pink-600 shadow-sm">
                            Guardar producto
                        </button>

                        <a href="{{ route('admin.products.index') }}"
                           class="w-full px-5 py-3 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 text-center">
                            Cancelar
                        </a>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    // ✅ Sync categorías (igual que lo tenías)
    const tipo = document.getElementById('tipo_producto');
    const ocasion = document.getElementById('ocasion_especial');
    const perso = document.getElementById('tipo_personalizacion');

    const c1 = document.getElementById('cat_1');
    const c2 = document.getElementById('cat_2');
    const c3 = document.getElementById('cat_3');

    function syncCats(){
      c1.value = tipo?.value || '';
      c2.value = ocasion?.value || '';
      c3.value = perso?.value || '';
    }

    [tipo, ocasion, perso].forEach(el => el?.addEventListener('change', syncCats));
    syncCats();

    // ✅ Preview de imagen (CORREGIDO: ahora usa imagen_principal)
    const inputImg = document.getElementById('imagen_principal');
    const imgPreview = document.getElementById('imgPreview');
    const imgPlaceholder = document.getElementById('imgPlaceholder');

    inputImg?.addEventListener('change', (e) => {
      const file = e.target.files?.[0];

      if (!file) {
        imgPreview.src = '';
        imgPreview.classList.add('hidden');
        imgPlaceholder.classList.remove('hidden');
        return;
      }

      const url = URL.createObjectURL(file);
      imgPreview.src = url;
      imgPreview.classList.remove('hidden');
      imgPlaceholder.classList.add('hidden');
    });
  });
</script>
@endpush
