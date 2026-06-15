@extends('layouts.admin')

@section('title', 'Inventario de extras')

@section('content')
<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">Inventario de extras</h1>
        <p class="text-sm text-gray-500 mt-1">
            Controla el stock de globos, chocolates, peluches y demás complementos.
        </p>
    </div>

    <form method="GET" action="{{ route('admin.inventory.extras') }}" class="bg-white rounded-2xl border border-pink-100 shadow-sm p-4">
        <div class="flex flex-col md:flex-row gap-3">
            <input
                type="text"
                name="buscar"
                value="{{ request('buscar') }}"
                placeholder="Buscar por nombre o SKU..."
                class="w-full rounded-xl border border-pink-100 px-4 py-2 focus:border-pink-300 focus:ring focus:ring-pink-100"
            >

            <button type="submit"
                    class="px-5 py-2 rounded-xl bg-pink-500 text-white font-semibold hover:bg-pink-600">
                Buscar
            </button>

            <a href="{{ route('admin.inventory.extras') }}"
               class="px-5 py-2 rounded-xl border border-pink-200 text-pink-600 font-semibold hover:bg-pink-50 text-center">
                Limpiar
            </a>
        </div>
    </form>

    <div class="bg-white rounded-2xl border border-pink-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-pink-50 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left">Extra</th>
                        <th class="px-4 py-3 text-left">SKU</th>
                        <th class="px-4 py-3 text-left">Stock actual</th>
                        <th class="px-4 py-3 text-left">Stock mínimo</th>
                        <th class="px-4 py-3 text-left">Controla stock</th>
                        <th class="px-4 py-3 text-left">Estado</th>
                        <th class="px-4 py-3 text-right">Actualizar</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-pink-100">
                    @forelse($extras as $extra)
                        @php
                            $stock = (int) ($extra->stock ?? 0);
                            $stockMinimo = (int) ($extra->stock_minimo ?? 0);

                            if (!$extra->controla_stock) {
                                $estadoTexto = 'Sin control';
                                $estadoClase = 'bg-gray-50 text-gray-600 border-gray-200';
                            } elseif ($stock <= 0) {
                                $estadoTexto = 'Sin stock';
                                $estadoClase = 'bg-red-50 text-red-600 border-red-200';
                            } elseif ($stock <= $stockMinimo) {
                                $estadoTexto = 'Stock bajo';
                                $estadoClase = 'bg-yellow-50 text-yellow-700 border-yellow-200';
                            } else {
                                $estadoTexto = 'Disponible';
                                $estadoClase = 'bg-green-50 text-green-600 border-green-200';
                            }
                        @endphp

                        <tr class="hover:bg-pink-50/40">
                            <td class="px-4 py-3">
                                <div class="font-semibold text-gray-800">
                                    {{ $extra->nombre }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $extra->activo ? 'Activo' : 'Inactivo' }}
                                </div>
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                {{ $extra->sku ?? 'Sin SKU' }}
                            </td>

                            <td class="px-4 py-3">
                                <form
                                    action="{{ route('admin.inventory.extras.updateStock', $extra) }}"
                                    method="POST"
                                    class="flex items-center gap-2"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <input
                                        type="number"
                                        name="stock"
                                        min="0"
                                        value="{{ old('stock', $stock) }}"
                                        class="w-24 rounded-xl border border-pink-100 px-3 py-2"
                                    >
                            </td>

                            <td class="px-4 py-3">
                                    <input
                                        type="number"
                                        name="stock_minimo"
                                        min="0"
                                        value="{{ old('stock_minimo', $stockMinimo) }}"
                                        class="w-24 rounded-xl border border-pink-100 px-3 py-2"
                                    >
                            </td>

                            <td class="px-4 py-3">
                                    <label class="inline-flex items-center gap-2">
                                        <input
                                            type="checkbox"
                                            name="controla_stock"
                                            value="1"
                                            class="rounded border-pink-200 text-pink-500"
                                            {{ $extra->controla_stock ? 'checked' : '' }}
                                        >
                                        <span class="text-gray-600">Sí</span>
                                    </label>
                            </td>

                            <td class="px-4 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $estadoClase }}">
                                    {{ $estadoTexto }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-right">
                                    <button
                                        type="submit"
                                        class="px-4 py-2 rounded-xl bg-pink-500 text-white font-semibold hover:bg-pink-600">
                                        Guardar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                No hay extras registrados en inventario.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($extras->hasPages())
            <div class="px-4 py-3 border-t border-pink-100">
                {{ $extras->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
