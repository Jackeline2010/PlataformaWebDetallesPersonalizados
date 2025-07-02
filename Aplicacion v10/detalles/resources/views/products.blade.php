@extends('layouts.app')

@section('title', 'Catálogo de Productos')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($products as $product)
        <div class="bg-white p-4 rounded-lg shadow-md">
            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-48 object-cover mb-4 rounded-t-lg">
            <h2 class="text-xl font-bold mb-2">{{ $product['name'] }}</h2>
            <p class="text-gray-700 mb-2">{{ $product['description'] }}</p>
            <p class="text-green-600 font-bold">${{ number_format($product['price'], 2) }}</p>
            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg mt-4">Comprar</button>
        </div>
    @endforeach
</div>
@endsection