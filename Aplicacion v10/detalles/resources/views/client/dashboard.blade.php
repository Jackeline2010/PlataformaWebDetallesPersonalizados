@extends('layouts.client')

@section('title', 'Mi Cuenta | SandyDecor')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    <h1 class="text-2xl font-bold text-pink-600 mb-6">
        Mi Cuenta
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        {{-- SIDEBAR --}}
        <aside class="md:col-span-1 bg-pink-50 rounded-lg p-4">
            @include('client.partials.sidebar')
        </aside>

        {{-- CONTENIDO --}}
        <section class="md:col-span-3 bg-white rounded-lg shadow p-6">

            <h2 class="text-xl font-semibold text-indigo-600 mb-4">
                Pedidos recientes
            </h2>

            @if(isset($orders) && $orders->count())
                <ul class="divide-y">
                    @foreach($orders as $order)
                        <li class="py-4 flex justify-between">
                            <span class="text-gray-700">
                                Pedido #{{ $order->id }}
                            </span>
                            <span class="font-semibold text-pink-600">
                                ${{ number_format($order->total, 2) }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">
                    No tienes pedidos aún.
                </p>
            @endif

        </section>

    </div>
</div>
@endsection
