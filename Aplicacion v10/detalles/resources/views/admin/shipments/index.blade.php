@extends('layouts.admin')

@section('title', 'Envíos')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Envíos</h1>
    <p class="text-gray-500 mb-6">Consulta la forma de entrega y datos de contacto de cada pedido.</p>

    <div class="bg-white rounded-2xl border border-pink-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-pink-50 text-gray-600">
                <tr>
                    <th class="px-4 py-3 text-left">Pedido</th>
                    <th class="px-4 py-3 text-left">Cliente</th>
                    <th class="px-4 py-3 text-left">Entrega</th>
                    <th class="px-4 py-3 text-left">Dirección</th>
                    <th class="px-4 py-3 text-left">Teléfono</th>
                    <th class="px-4 py-3 text-right">Costo envío</th>
                    <th class="px-4 py-3 text-left">Estado</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-pink-100">
                @forelse($orders as $order)
                    @php
                        $tipoEntrega = $order->tipo_entrega === 'retiro_tienda'
                            ? 'Retiro en tienda'
                            : 'Entrega a domicilio';

                        $estadoClass = match($order->estado) {
                            'ENT' => 'bg-green-100 text-green-700',
                            'ENV' => 'bg-purple-100 text-purple-700',
                            'PRO' => 'bg-blue-100 text-blue-700',
                            'CAN' => 'bg-red-100 text-red-700',
                            default => 'bg-yellow-100 text-yellow-700',
                        };

                        $estadoTexto = match($order->estado) {
                            'ENT' => 'Entregado',
                            'ENV' => 'Enviado',
                            'PRO' => 'En proceso',
                            'CAN' => 'Cancelado',
                            default => 'Pendiente',
                        };
                    @endphp

                    <tr>
                        <td class="px-4 py-3 font-semibold">
                            {{ $order->numero_orden ?? '#' . $order->id }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $order->user->name ?? 'Cliente' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $tipoEntrega }}
                        </td>

                        <td class="px-4 py-3 text-gray-600 max-w-xs">
                            {{ $order->direccion_entrega ?? 'No aplica' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $order->telefono_contacto ?? 'No registrado' }}
                        </td>

                        <td class="px-4 py-3 text-right font-semibold text-pink-600">
                            ${{ number_format((float) ($order->costo_entrega ?? 0), 2) }}
                        </td>

                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $estadoClass }}">
                                {{ $estadoTexto }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-10 text-center text-gray-500">
                            No hay envíos registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($orders, 'links'))
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
