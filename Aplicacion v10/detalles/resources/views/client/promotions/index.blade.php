@extends('layouts.client')

@section('title', 'Promociones | SandyDecor')

@section('content')
<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-extrabold text-gray-900">
            Promociones disponibles
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Usa estos códigos al finalizar tu compra.
        </p>
    </div>

    @if($promotions->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($promotions as $promotion)
                <div class="bg-white/80 border border-pink-100 rounded-3xl p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h2 class="text-xl font-extrabold text-pink-700">
                                @if($promotion->tipo === 'porcentaje')
                                    {{ number_format((float) $promotion->valor, 0) }}% Descuento
                                @else
                                    ${{ number_format((float) $promotion->valor, 2) }} Descuento
                                @endif
                            </h2>

                            <p class="text-gray-800 font-bold mt-2">
                                {{ $promotion->nombre }}
                            </p>
                        </div>

                        <span class="text-xs font-bold bg-pink-50 text-pink-600 border border-pink-200 px-3 py-1 rounded-full">
                            Activa
                        </span>
                    </div>

                    <div class="mt-4 space-y-1 text-sm text-gray-600">
                        <p>
                            Código:
                            <span class="font-extrabold text-gray-900">
                                {{ $promotion->codigo }}
                            </span>
                        </p>

                        <p>
                            Compra mínima:
                            <span class="font-bold">
                                ${{ number_format((float) $promotion->compra_minima, 2) }}
                            </span>
                        </p>

                        @if($promotion->fecha_fin)
                            <p>
                                Válido hasta:
                                <span class="font-bold">
                                    {{ $promotion->fecha_fin }}
                                </span>
                            </p>
                        @endif
                    </div>

                    <a href="{{ route('client.cart.index', ['coupon' => $promotion->codigo]) }}"
                       class="inline-flex mt-5 rounded-xl bg-pink-600 px-5 py-2.5 text-sm font-extrabold text-white hover:bg-pink-700">
                        Usar cupón
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white border border-pink-100 rounded-3xl p-8 text-center">
            <p class="text-gray-500">
                No hay promociones activas por el momento.
            </p>
        </div>
    @endif

</div>
@endsection
