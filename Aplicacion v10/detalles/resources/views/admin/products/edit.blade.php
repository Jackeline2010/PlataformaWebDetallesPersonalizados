@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-4">Editar Producto</h1>

@if ($errors->any())
<div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
    <ul>
        @foreach ($errors->all() as $error)
        <li>• {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST"
      action="{{ route('admin.products.update', $product) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="block">Nombre</label>
        <input type="text" name="nombre"
               class="w-full border p-2"
               value="{{ old('nombre', $product->nombre) }}" required>
    </div>

    <div class="mb-3">
        <label class="block">Precio</label>
        <input type="number" step="0.01" name="precio"
               class="w-full border p-2"
               value="{{ old('precio', $product->precio) }}" required>
    </div>

    <div class="mb-3">
        <label class="block">Stock</label>
        <input type="number" name="stock"
               class="w-full border p-2"
               value="{{ old('stock', $product->stock) }}" required>
    </div>

    <div class="mb-3">
        <label class="block">Categorías</label>
        <select name="categories[]" multiple
                class="w-full border p-2">
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ $product->categories->contains($category->id) ? 'selected' : '' }}>
                    {{ $category->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <button class="bg-pink-600 text-white px-4 py-2 rounded">
        Actualizar producto
    </button>

    <a href="{{ route('admin.products.index') }}"
       class="ml-3 text-gray-600">
       Cancelar
    </a>
</form>
@endsection
