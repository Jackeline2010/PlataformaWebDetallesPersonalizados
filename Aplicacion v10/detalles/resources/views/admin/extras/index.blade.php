@extends('layouts.admin')
@section('title', 'Extras')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Catálogo de Extras</h1>
            <p class="text-sm text-gray-500">Gestiona los extras que podrán agregarse a los productos.</p>
        </div>

        <a href="{{ route('admin.extras.create') }}"
           class="px-4 py-2 rounded-xl bg-pink-600 text-white hover:bg-pink-700 shadow">
            + Nuevo Extra
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
                        <th class="px-4 py-3 text-left">Imagen</th>
                        <th class="px-4 py-3 text-left">Nombre</th>
                        <th class="px-4 py-3 text-left">Tipo</th>
                        <th class="px-4 py-3 text-left">Precio adicional</th>
                        <th class="px-4 py-3 text-left">Estado</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($extras as $extra)
                        <tr class="border-t border-pink-50">
                            <td class="px-4 py-3">
                                @if($extra->imagen)
                                    <img src="{{ asset('storage/' . $extra->imagen) }}"
                                         class="w-16 h-16 object-cover rounded-xl border">
                                @else
                                    <div class="w-16 h-16 rounded-xl bg-gray-100 flex items-center justify-center text-gray-400">
                                        Sin imagen
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $extra->nombre }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $extra->tipo ?? '-' }}</td>
                            <td class="px-4 py-3 text-pink-600 font-semibold">${{ number_format($extra->precio_adicional, 2) }}</td>
                            <td class="px-4 py-3">
                                @if($extra->activo)
                                    <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">Activo</span>
                                @else
                                    <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-600">Inactivo</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.extras.edit', $extra) }}"
                                       class="px-3 py-2 rounded-lg border border-blue-200 text-blue-600 hover:bg-blue-50">
                                        Editar
                                    </a>

                                    <form action="{{ route('admin.extras.destroy', $extra) }}" method="POST"
                                          onsubmit="return confirm('¿Deseas eliminar este extra?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-2 rounded-lg border border-red-200 text-red-600 hover:bg-red-50">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                No hay extras registrados todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
