@extends('layouts.client')
@section('title', $product->nombre ?? 'Producto')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
  <h1 class="text-2xl font-bold">{{ $product->nombre }}</h1>
</div>
@endsection
