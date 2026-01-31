@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-4">Productos</h1>

<a href="{{ route('admin.products.create') }}"
   class="bg-pink-600 text-white px-4 py-2 rounded">
   + Nuevo Producto
</a>

<table class="w-full mt-4 border">
    <thead>
        <tr class="bg-gray-100">
            <th class="p-2">Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr class="border-t">
            <td class="p-2">{{ $product->nombre }}</td>
            <td>${{ $product->precio }}</td>
            <td>{{ $product->stock }}</td>
            <td class="flex gap-2 p-2">
                <a href="{{ route('admin.products.edit', $product) }}"
                   class="text-blue-600">Editar</a>

                <form method="POST"
                      action="{{ route('admin.products.destroy', $product) }}">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
