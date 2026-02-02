@extends('layouts.admin')
@section('title','Nuevo Producto')

@section('content')
<div class="max-w-4xl mx-auto">

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

        <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- GRID PRINCIPAL --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- NOMBRE --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre del producto *</label>
                    <input
                        name="nombre"
                        value="{{ old('nombre') }}"
                        placeholder="Ej: Arreglo floral, Caja regalo, Vela aromática..."
                        class="w-full rounded-xl border border-pink-200 bg-white px-4 py-3
                               focus:outline-none focus:ring-2 focus:ring-pink-300"
                        required
                    >
                    @error('nombre')
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
                            value="{{ old('precio') }}"
                            placeholder="0.00"
                            class="w-full pl-9 rounded-xl border border-pink-200 bg-white px-4 py-3
                                   focus:outline-none focus:ring-2 focus:ring-pink-300"
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
                        value="{{ old('stock', 0) }}"
                        class="w-full rounded-xl border border-pink-200 bg-white px-4 py-3
                               focus:outline-none focus:ring-2 focus:ring-pink-300"
                    >
                    @error('stock')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- CATEGORÍA PRINCIPAL (1 sola) --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Categoría principal *</label>

                    <select
                        name="category_id"
                        required
                        class="w-full rounded-xl border border-pink-200 bg-white px-4 py-3
                               focus:outline-none focus:ring-2 focus:ring-pink-300"
                    >
                        <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>
                            Selecciona una categoría...
                        </option>

                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
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
                        class="w-full rounded-xl border border-pink-200 bg-white px-4 py-3
                               focus:outline-none focus:ring-2 focus:ring-pink-300"
                    >
                    @error('descripcion_corta')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ACTIVO (SWITCH) --}}
                <div class="md:col-span-2 flex items-center justify-between p-4 rounded-2xl bg-pink-50 border border-pink-100">
                    <div>
                        <p class="font-semibold text-gray-700">Producto activo</p>
                        <p class="text-xs text-gray-500">Si está inactivo no se mostrará en la tienda.</p>
                    </div>

                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="activo" value="1" class="sr-only peer"
                               {{ old('activo', 1) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-pink-500 relative transition">
                            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full transition
                                        peer-checked:translate-x-5"></div>
                        </div>
                    </label>
                </div>

            </div>

            {{-- BOTONES --}}
            <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
                <a href="{{ route('admin.products.index') }}"
                   class="px-5 py-3 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 text-center">
                    Volver
                </a>

                <button
                    type="submit"
                    class="px-6 py-3 rounded-xl bg-pink-500 text-white font-semibold hover:bg-pink-600 shadow-sm">
                    Guardar producto
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
