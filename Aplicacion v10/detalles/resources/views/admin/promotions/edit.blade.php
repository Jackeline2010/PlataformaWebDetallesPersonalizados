@extends('layouts.admin')

@section('title', 'Editar promoción')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Editar promoción
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Modifica los datos del cupón o promoción.
        </p>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.promotions.update', $promotion) }}" method="POST" class="bg-white rounded-2xl border border-pink-100 shadow-sm p-6 space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Nombre de la promoción
            </label>
            <input
                type="text"
                name="nombre"
                value="{{ old('nombre', $promotion->nombre) }}"
                class="w-full rounded-xl border border-pink-100 px-4 py-2"
                required
            >
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Código del cupón
            </label>
            <input
                type="text"
                name="codigo"
                value="{{ old('codigo', $promotion->codigo) }}"
                class="w-full rounded-xl border border-pink-100 px-4 py-2 uppercase"
                required
            >
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Tipo de descuento
                </label>
                <select name="tipo" class="w-full rounded-xl border border-pink-100 px-4 py-2" required>
                    <option value="porcentaje" {{ old('tipo', $promotion->tipo) === 'porcentaje' ? 'selected' : '' }}>
                        Porcentaje
                    </option>
                    <option value="monto_fijo" {{ old('tipo', $promotion->tipo) === 'monto_fijo' ? 'selected' : '' }}>
                        Monto fijo
                    </option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Valor
                </label>
                <input
                    type="number"
                    step="0.01"
                    min="0.01"
                    name="valor"
                    value="{{ old('valor', $promotion->valor) }}"
                    class="w-full rounded-xl border border-pink-100 px-4 py-2"
                    required
                >
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Compra mínima
                </label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="compra_minima"
                    value="{{ old('compra_minima', $promotion->compra_minima) }}"
                    class="w-full rounded-xl border border-pink-100 px-4 py-2"
                >
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Límite de usos
                </label>
                <input
                    type="number"
                    min="1"
                    name="limite_usos"
                    value="{{ old('limite_usos', $promotion->limite_usos) }}"
                    placeholder="Vacío = sin límite"
                    class="w-full rounded-xl border border-pink-100 px-4 py-2"
                >
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Fecha de inicio
                </label>
                <input
                    type="date"
                    name="fecha_inicio"
                    value="{{ old('fecha_inicio', optional($promotion->fecha_inicio)->format('Y-m-d') ?? $promotion->fecha_inicio) }}"
                    class="w-full rounded-xl border border-pink-100 px-4 py-2"
                >
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Fecha de fin
                </label>
                <input
                    type="date"
                    name="fecha_fin"
                    value="{{ old('fecha_fin', optional($promotion->fecha_fin)->format('Y-m-d') ?? $promotion->fecha_fin) }}"
                    class="w-full rounded-xl border border-pink-100 px-4 py-2"
                >
            </div>
        </div>

        <div class="rounded-xl bg-pink-50 border border-pink-100 px-4 py-3 text-sm text-gray-600">
            <p>
                Usos actuales:
                <span class="font-semibold text-gray-800">
                    {{ $promotion->usos_actuales ?? 0 }}
                </span>
            </p>
        </div>

        <label class="flex items-center gap-2">
            <input
                type="checkbox"
                name="activo"
                value="1"
                class="rounded border-pink-200 text-pink-500"
                {{ old('activo', $promotion->activo) ? 'checked' : '' }}
            >
            <span class="text-sm font-semibold text-gray-700">
                Promoción activa
            </span>
        </label>

        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('admin.promotions.index') }}"
               class="px-4 py-2 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold">
                Cancelar
            </a>

            <button
                type="submit"
                class="px-5 py-2 rounded-xl bg-pink-500 text-white font-semibold hover:bg-pink-600">
                Actualizar promoción
            </button>
        </div>
    </form>
</div>
@endsection
