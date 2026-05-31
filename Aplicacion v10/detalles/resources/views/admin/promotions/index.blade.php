@extends('layouts.admin')

@section('title', 'Promociones')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Promociones
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Administra cupones y descuentos por temporada.
            </p>
        </div>

        <a href="{{ route('admin.promotions.create') }}"
           class="inline-flex items-center px-4 py-2 rounded-xl bg-pink-500 text-white font-semibold hover:bg-pink-600">
            + Nueva promoción
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-pink-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-pink-50 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left">Nombre</th>
                        <th class="px-4 py-3 text-left">Código</th>
                        <th class="px-4 py-3 text-left">Tipo</th>
                        <th class="px-4 py-3 text-left">Valor</th>
                        <th class="px-4 py-3 text-left">Compra mínima</th>
                        <th class="px-4 py-3 text-left">Vigencia</th>
                        <th class="px-4 py-3 text-left">Usos</th>
                        <th class="px-4 py-3 text-left">Estado</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-pink-100">
                    @forelse($promotions as $promotion)
                        <tr class="hover:bg-pink-50/40">
                            <td class="px-4 py-3 font-semibold text-gray-800">
                                {{ $promotion->nombre }}
                            </td>

                            <td class="px-4 py-3">
                                <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 font-semibold">
                                    {{ $promotion->codigo }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                {{ $promotion->tipo === 'porcentaje' ? 'Porcentaje' : 'Monto fijo' }}
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                @if($promotion->tipo === 'porcentaje')
                                    {{ number_format((float) $promotion->valor, 2) }}%
                                @else
                                    ${{ number_format((float) $promotion->valor, 2) }}
                                @endif
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                ${{ number_format((float) $promotion->compra_minima, 2) }}
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                {{ $promotion->fecha_inicio ?? 'Sin inicio' }}
                                <br>
                                {{ $promotion->fecha_fin ?? 'Sin fin' }}
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                {{ $promotion->usos_actuales ?? 0 }}
                                /
                                {{ $promotion->limite_usos ?? '∞' }}
                            </td>

                            <td class="px-4 py-3">
                                @if($promotion->activo)
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-600 border border-green-200">
                                        Activa
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-600 border border-red-200">
                                        Inactiva
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.promotions.edit', $promotion) }}"
                                       class="px-3 py-1 rounded-lg bg-blue-50 text-blue-600 font-semibold hover:bg-blue-100">
                                        Editar
                                    </a>

                                    <form action="{{ route('admin.promotions.destroy', $promotion) }}"
                                          method="POST"
                                          onsubmit="return confirm('¿Seguro que deseas eliminar esta promoción?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="px-3 py-1 rounded-lg bg-red-50 text-red-600 font-semibold hover:bg-red-100">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                                Aún no hay promociones registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($promotions->hasPages())
            <div class="px-4 py-3 border-t border-pink-100">
                {{ $promotions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
