@extends('layouts.admin')
@section('title', 'Personalización | ' . $product->nombre)

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

  {{-- Header --}}
  <div class="flex items-start justify-between gap-4">
    <div>
      <h1 class="text-2xl font-extrabold text-gray-800">Personalización del producto</h1>
      <p class="text-sm text-gray-500 mt-1">
        Configura los campos que el cliente completará al comprar.
      </p>
      <div class="mt-2 text-sm">
        <span class="font-semibold text-gray-700">{{ $product->nombre }}</span>
        <span class="text-gray-400">•</span>
        <span class="text-gray-600">ID: {{ $product->id }}</span>
      </div>
    </div>

    <a href="{{ route('admin.products.index') }}"
       class="px-4 py-2 rounded-xl border border-pink-200 bg-white hover:bg-pink-50">
      ← Volver
    </a>
  </div>

  {{-- Form: Agregar campo --}}
<div class="bg-white/80 border border-pink-100 rounded-2xl p-5 shadow-sm">
  <h2 class="text-lg font-extrabold text-gray-800">Añadir campo</h2>

  <form method="POST"
        action="{{ route('admin.products.personalization.fields.store', $product) }}"
        class="mt-4 grid grid-cols-1 md:grid-cols-6 gap-3">
    @csrf

    {{-- Nombre --}}
    <div class="md:col-span-2">
      <label class="text-xs font-semibold text-gray-600">Nombre del campo</label>
      <input name="label" value="{{ old('label') }}"
             placeholder="Ej: Frase en globo"
             class="mt-1 w-full rounded-xl border border-pink-200 bg-white px-3 py-2 outline-none focus:ring-2 focus:ring-pink-300">
    </div>

    {{-- Tipo --}}
    <div>
      <label class="text-xs font-semibold text-gray-600">Tipo</label>
      <select name="type"
              class="mt-1 w-full rounded-xl border border-pink-200 bg-white px-3 py-2 outline-none focus:ring-2 focus:ring-pink-300">
        <option value="text">Texto</option>
        <option value="textarea">Texto largo</option>
        <option value="select">Selección</option>
      </select>
    </div>

    {{-- Máx caracteres --}}
    <div>
      <label class="text-xs font-semibold text-gray-600">Máx. caracteres</label>
      <input type="number" name="max_length"
             placeholder="Solo texto"
             class="mt-1 w-full rounded-xl border border-pink-200 bg-white px-3 py-2 outline-none focus:ring-2 focus:ring-pink-300">
    </div>

    {{-- NUEVO: Texto de ayuda --}}
    <div class="md:col-span-2">
      <label class="text-xs font-semibold text-gray-600">Texto de ayuda (opcional)</label>
      <input name="help_text" value="{{ old('help_text') }}"
             placeholder="Ej: Máx. 40 caracteres"
             class="mt-1 w-full rounded-xl border border-pink-200 bg-white px-3 py-2 outline-none focus:ring-2 focus:ring-pink-300">
    </div>

    {{-- Obligatorio --}}
    <div class="flex items-end">
      <label class="flex items-center gap-2 text-sm text-gray-700">
        <input type="checkbox" name="is_required" value="1" class="rounded border-pink-200">
        Obligatorio
      </label>
    </div>

    <div class="md:col-span-6 flex justify-end">
      <button type="submit"
              class="px-5 py-2.5 rounded-xl bg-pink-600 hover:bg-pink-700 text-white font-bold shadow-sm">
        + Agregar
      </button>
    </div>

  </form>
</div>

    <p class="text-xs text-gray-500 mt-3">
      Nota: <span class="font-semibold">Máx. caracteres</span> aplica solo para tipo <span class="font-semibold">Texto</span>.
    </p>
  </div>

  {{-- Lista de campos --}}
  <div class="space-y-4">
    <h2 class="text-lg font-extrabold text-gray-800">Campos configurados</h2>

    @forelse($product->customFields as $field)
      <div class="bg-white/80 border border-pink-100 rounded-2xl p-5 shadow-sm">
        <div class="flex items-start justify-between gap-4">

          <div class="min-w-0">
            <div class="flex flex-wrap items-center gap-2">
              <h3 class="text-base font-extrabold text-gray-800 truncate">{{ $field->label }}</h3>

              <span class="text-xs px-2 py-1 rounded-full bg-pink-100 text-pink-700 font-semibold">
                {{ strtoupper($field->type) }}
              </span>

              @if($field->is_required)
                <span class="text-xs px-2 py-1 rounded-full bg-red-100 text-red-700 font-semibold">
                  OBLIGATORIO
                </span>
              @else
                <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-700 font-semibold">
                  OPCIONAL
                </span>
              @endif

              @if(!$field->is_active)
                <span class="text-xs px-2 py-1 rounded-full bg-yellow-100 text-yellow-800 font-semibold">
                  INACTIVO
                </span>
              @endif
            </div>

            @if($field->help_text)
              <p class="text-sm text-gray-500 mt-1">{{ $field->help_text }}</p>
            @endif

            @if($field->max_length)
              <p class="text-xs text-gray-400 mt-1">Máximo: {{ $field->max_length }} caracteres</p>
            @endif
          </div>

          <div class="flex items-center gap-2 whitespace-nowrap">
            {{-- Toggle activo/inactivo con modal --}}
            <form id="toggleFieldForm-{{ $field->id }}"
                  method="POST"
                  action="{{ route('admin.personalization.fields.toggle', $field->id) }}"
                  class="inline">
              @csrf
              @method('PATCH')

              <button type="button"
                      data-confirm-submit="toggleFieldForm-{{ $field->id }}"
                      data-confirm-title="Confirmar"
                      data-confirm-message="¿Deseas {{ $field->is_active ? 'desactivar' : 'activar' }} el campo: {{ e($field->label) }}?"
                      data-confirm-ok="Sí, continuar"
                      data-confirm-cancel="Cancelar"
                      class="px-3 py-2 rounded-xl border border-pink-200 bg-white hover:bg-pink-50 text-sm font-semibold">
                {{ $field->is_active ? 'Desactivar' : 'Activar' }}
              </button>
            </form>

            {{-- Eliminar campo con modal --}}
            <form id="deleteFieldForm-{{ $field->id }}"
                  method="POST"
                  action="{{ route('admin.personalization.fields.destroy', $field->id) }}"
                  class="inline">
              @csrf
              @method('DELETE')

              <button type="button"
                      data-confirm-submit="deleteFieldForm-{{ $field->id }}"
                      data-confirm-title="Confirmar eliminación"
                      data-confirm-message="¿Seguro que deseas eliminar el campo: {{ e($field->label) }}? Esta acción no se puede deshacer."
                      data-confirm-ok="Sí, eliminar"
                      data-confirm-cancel="Cancelar"
                      data-confirm-danger="1"
                      class="px-3 py-2 rounded-xl text-sm font-semibold text-red-600 hover:underline">
                Eliminar
              </button>
            </form>
          </div>

        </div>

        {{-- Opciones (si select) --}}
        @if($field->type === 'select')
          <div class="mt-4 grid grid-cols-1 lg:grid-cols-2 gap-4">

            {{-- Lista opciones --}}
            <div class="rounded-xl border border-pink-100 bg-pink-50 p-4">
              <p class="font-bold text-gray-800">Opciones</p>

              <ul class="mt-3 space-y-2">
                @forelse($field->options as $opt)
                  <li class="flex items-center justify-between gap-3 bg-white rounded-xl border border-pink-100 px-3 py-2">
                    <div class="text-sm text-gray-700">
                      <span class="font-semibold">{{ $opt->label }}</span>
                      @if((float)$opt->extra_price > 0)
                        <span class="text-gray-500">(+${{ number_format($opt->extra_price,2) }})</span>
                      @endif
                    </div>

                    <form id="deleteOptionForm-{{ $opt->id }}"
                          method="POST"
                          action="{{ route('admin.personalization.options.destroy', $opt->id) }}"
                          class="inline">
                      @csrf
                      @method('DELETE')

                      <button type="button"
                              data-confirm-submit="deleteOptionForm-{{ $opt->id }}"
                              data-confirm-title="Confirmar eliminación"
                              data-confirm-message="¿Eliminar la opción: {{ e($opt->label) }}?"
                              data-confirm-ok="Sí, eliminar"
                              data-confirm-cancel="Cancelar"
                              data-confirm-danger="1"
                              class="text-sm font-semibold text-red-600 hover:text-red-700">
                        Eliminar
                      </button>
                    </form>
                  </li>
                @empty
                  <li class="text-sm text-gray-500">Aún no hay opciones.</li>
                @endforelse
              </ul>
            </div>

            {{-- Agregar opción --}}
            <div class="rounded-xl border border-pink-100 bg-white p-4">
              <p class="font-bold text-gray-800">Agregar opción</p>

              <form method="POST"
                    action="{{ route('admin.personalization.options.store', $field->id) }}"
                    class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-3">
                @csrf

                <div class="md:col-span-2">
                  <label class="text-xs font-semibold text-gray-600">Nombre</label>
                  <input name="label"
                         class="mt-1 w-full rounded-xl border border-pink-200 bg-white px-3 py-2 outline-none focus:ring-2 focus:ring-pink-300"
                         placeholder="Ej: Grande">
                </div>

                <div>
                  <label class="text-xs font-semibold text-gray-600">Extra $</label>
                  <input name="extra_price" type="number" step="0.01" min="0"
                         class="mt-1 w-full rounded-xl border border-pink-200 bg-white px-3 py-2 outline-none focus:ring-2 focus:ring-pink-300"
                         placeholder="0.00">
                </div>

                <div class="md:col-span-3 flex justify-end">
                  <button type="submit"
                          class="px-4 py-2 rounded-xl bg-pink-600 hover:bg-pink-700 text-white font-bold">
                    + Agregar opción
                  </button>
                </div>
              </form>
            </div>

          </div>
        @endif

      </div>
    @empty
      <div class="rounded-2xl border border-pink-100 bg-white/80 p-6 text-gray-600">
        Aún no hay campos de personalización para este producto.
      </div>
    @endforelse
  </div>

</div>
@endsection
