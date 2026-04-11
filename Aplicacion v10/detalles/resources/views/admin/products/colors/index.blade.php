@extends('layouts.admin')

@section('title', 'Colores del producto | ' . $product->nombre)

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- ENCABEZADO --}}
    <div class="bg-white border border-pink-100 rounded-2xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Colores del producto
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Aquí puedes registrar los colores disponibles para:
                    <span class="font-semibold text-pink-600">{{ $product->nombre }}</span>
                </p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.products.edit', $product->id) }}"
                   class="inline-flex items-center px-4 py-2 rounded-xl border border-pink-200 bg-white text-pink-700 hover:bg-pink-50 transition">
                    Editar producto
                </a>

                <a href="{{ route('admin.products.index') }}"
                   class="inline-flex items-center px-4 py-2 rounded-xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                    Volver al listado
                </a>
            </div>
        </div>
    </div>

    {{-- RESUMEN DEL PRODUCTO --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white border border-pink-100 rounded-2xl p-5 shadow-sm h-full">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    Producto base
                </h2>

                <div class="rounded-2xl overflow-hidden border border-pink-100 bg-pink-50">
                    @if($product->imagen_principal)
                        <img src="{{ asset('storage/' . $product->imagen_principal) }}"
                             alt="{{ $product->nombre }}"
                             class="w-full h-72 object-cover">
                    @else
                        <div class="w-full h-72 flex items-center justify-center text-gray-400 text-sm">
                            Sin imagen principal
                        </div>
                    @endif
                </div>

                <div class="mt-4 space-y-2">
                    <p class="text-sm text-gray-500">Nombre</p>
                    <p class="font-semibold text-gray-800">{{ $product->nombre }}</p>

                    <p class="text-sm text-gray-500 mt-3">Precio base</p>
                    <p class="font-semibold text-pink-600">
                        ${{ number_format($product->precio, 2) }}
                    </p>

                    @if(!empty($product->descripcion_corta))
                        <p class="text-sm text-gray-500 mt-3">Descripción corta</p>
                        <p class="text-sm text-gray-700">{{ $product->descripcion_corta }}</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- FORMULARIO AGREGAR COLOR --}}
        <div class="lg:col-span-2">
            <div class="bg-white border border-pink-100 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-800 mb-1">
                    Agregar nuevo color
                </h2>
                <p class="text-sm text-gray-500 mb-6">
                    Registra una imagen real del producto con su color correspondiente y el stock disponible.
                </p>

                <form action="{{ route('admin.products.colors.store', $product->id) }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Nombre del color --}}
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre del color <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="nombre"
                                name="nombre"
                                value="{{ old('nombre') }}"
                                placeholder="Ejemplo: Rojo, Azul, Rosa"
                                class="w-full rounded-xl border border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                            @error('nombre')
                                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Stock --}}
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                                Stock disponible <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="number"
                                id="stock"
                                name="stock"
                                min="0"
                                value="{{ old('stock', 0) }}"
                                class="w-full rounded-xl border border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                            @error('stock')
                                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Imagen --}}
                    <div>
                        <label for="imagen" class="block text-sm font-medium text-gray-700 mb-2">
                            Imagen del color
                        </label>
                        <input
                            type="file"
                            id="imagen"
                            name="imagen"
                            accept="image/*"
                            class="w-full rounded-xl border border-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                        <p class="text-xs text-gray-500 mt-2">
                            Sube una foto real del producto con este color. Formatos permitidos: jpg, jpeg, png, webp.
                        </p>
                        @error('imagen')
                            <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <button type="submit"
                                class="inline-flex items-center px-5 py-2.5 rounded-xl bg-pink-600 text-white font-medium hover:bg-pink-700 transition">
                            Guardar color
                        </button>

                        <a href="{{ route('admin.products.index') }}"
                           class="inline-flex items-center px-5 py-2.5 rounded-xl border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition">
                            Finalizar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- LISTADO DE COLORES --}}
    <div class="bg-white border border-pink-100 rounded-2xl p-6 shadow-sm">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">
                    Colores registrados
                </h2>
                <p class="text-sm text-gray-500">
                    Aquí se muestran los colores ya agregados a este producto.
                </p>
            </div>

            <div class="text-sm text-pink-700 bg-pink-50 border border-pink-100 px-3 py-2 rounded-xl">
                Total: <span class="font-semibold">{{ $colors->count() }}</span>
            </div>
        </div>

        @if($colors->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                @foreach($colors as $color)
                    <div class="border border-pink-100 rounded-2xl overflow-hidden bg-white shadow-sm">
                        <div class="bg-pink-50 border-b border-pink-100">
                            @if($color->imagen)
                                <img src="{{ asset('storage/' . $color->imagen) }}"
                                     alt="{{ $color->nombre }}"
                                     class="w-full h-52 object-cover">
                            @else
                                <div class="w-full h-52 flex items-center justify-center text-gray-400 text-sm">
                                    Sin imagen
                                </div>
                            @endif
                        </div>

                        <div class="p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h3 class="font-semibold text-gray-800">
                                        {{ $color->nombre }}
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Stock disponible:
                                        <span class="font-medium text-gray-700">{{ $color->stock }}</span>
                                    </p>
                                </div>

                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                    Activo
                                </span>
                            </div>

                            <div class="mt-4 flex gap-2">
                                <form action="{{ route('admin.colors.destroy', $color->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Deseas eliminar este color?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 rounded-xl bg-red-50 text-red-600 border border-red-100 hover:bg-red-100 transition">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-pink-200 bg-pink-50 p-10 text-center">
                <div class="text-4xl mb-3">🎨</div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">
                    Aún no has registrado colores
                </h3>
                <p class="text-sm text-gray-500 max-w-xl mx-auto">
                    Agrega el primer color disponible para este producto. Cada color puede tener su propia imagen y stock.
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
