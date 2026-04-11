@extends('layouts.admin')
@section('title', 'Personalización | ' . $product->nombre)

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="bg-white border border-pink-100 rounded-2xl p-6 shadow-sm">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Personalización del producto</h1>
                <p class="text-gray-500 text-sm">
                    Producto: <span class="text-pink-600 font-semibold">{{ $product->nombre }}</span>
                </p>
            </div>

            <a href="{{ route('admin.products.index') }}"
               class="px-4 py-2 border border-pink-200 rounded-xl hover:bg-pink-50 transition">
                Volver
            </a>
        </div>
    </div>

    {{-- ALERTAS --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM PRINCIPAL --}}
    <form action="{{ route('admin.products.personalization.update', $product->id) }}"
          method="POST"
          class="space-y-6">
        @csrf
        @method('PUT')

        {{-- ACTIVAR PERSONALIZACIÓN --}}
        <div class="bg-white border border-pink-100 rounded-2xl p-6 shadow-sm">
            <h2 class="font-bold mb-2 text-gray-800">Activar personalización</h2>

            <label class="flex items-center gap-2">
                <input type="checkbox"
                       name="personalizacion_activa"
                       value="1"
                       {{ old('personalizacion_activa', $product->personalizable) ? 'checked' : '' }}>
                <span>Permitir personalizar este producto</span>
            </label>

            <p class="text-sm text-gray-500 mt-3">
                Al activar esta opción, podrás definir qué podrá escribir, subir o elegir el cliente según el tipo de arreglo.
            </p>
        </div>

        {{-- OPCIONES PRINCIPALES --}}
        <div class="bg-white border border-pink-100 rounded-2xl p-6 shadow-sm">
            <div class="flex items-start justify-between gap-4 mb-6 flex-col lg:flex-row">
                <div>
                    <h2 class="font-bold text-gray-800">Opciones de personalización</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Configura qué opciones estarán disponibles para el cliente en este producto.
                    </p>
                </div>

                <div class="text-xs text-pink-600 bg-pink-50 border border-pink-100 px-3 py-1 rounded-full">
                    El admin configura, el cliente personaliza
                </div>
            </div>

            {{-- TARJETAS PRINCIPALES --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

                {{-- DEDICATORIA --}}
                <label class="relative border border-pink-200 rounded-2xl p-5 bg-white shadow-sm hover:shadow-md hover:border-pink-300 transition cursor-pointer">
                    <input type="checkbox"
                           id="enable_dedicatoria"
                           name="enable_dedicatoria"
                           value="1"
                           class="personalization-toggle sr-only"
                           data-target="config-dedicatoria"
                           {{ old('enable_dedicatoria', $dedicatoriaField ? 1 : 0) ? 'checked' : '' }}>

                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="w-11 h-11 rounded-2xl bg-pink-100 text-pink-600 flex items-center justify-center text-lg">
                            💌
                        </div>

                        <div class="flex items-center gap-2">
                            <span id="status-dedicatoria" class="text-xs font-medium text-gray-400 transition">
                                Inactivo
                            </span>

                            <div class="relative w-11 h-6 bg-gray-200 rounded-full transition switch-track">
                                <span class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full transition-transform switch-thumb"></span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-800 text-base">Dedicatoria</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Permite que el cliente escriba un mensaje para la tarjeta.
                        </p>
                    </div>

                    <div class="mt-4">
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium bg-pink-50 text-pink-700 border border-pink-100">
                            Texto personalizado
                        </span>
                    </div>

                    <div class="absolute inset-0 rounded-2xl ring-2 ring-transparent pointer-events-none transition card-ring"></div>
                </label>

                {{-- FOTO --}}
                <label class="relative border border-pink-200 rounded-2xl p-5 bg-white shadow-sm hover:shadow-md hover:border-pink-300 transition cursor-pointer">
                    <input type="checkbox"
                           id="enable_foto"
                           name="enable_foto"
                           value="1"
                           class="personalization-toggle sr-only"
                           data-target="config-foto"
                           {{ old('enable_foto', $fotoField ? 1 : 0) ? 'checked' : '' }}>

                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="w-11 h-11 rounded-2xl bg-pink-100 text-pink-600 flex items-center justify-center text-lg">
                            🖼️
                        </div>

                        <div class="flex items-center gap-2">
                            <span id="status-foto" class="text-xs font-medium text-gray-400 transition">
                                Inactivo
                            </span>

                            <div class="relative w-11 h-6 bg-gray-200 rounded-full transition switch-track">
                                <span class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full transition-transform switch-thumb"></span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-800 text-base">Foto del cliente</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Permite que el cliente suba una imagen para colocarla en el arreglo.
                        </p>
                    </div>

                    <div class="mt-4">
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium bg-pink-50 text-pink-700 border border-pink-100">
                            Subida de imagen
                        </span>
                    </div>

                    <div class="absolute inset-0 rounded-2xl ring-2 ring-transparent pointer-events-none transition card-ring"></div>
                </label>

                {{-- COLOR --}}
                <label class="relative border border-pink-200 rounded-2xl p-5 bg-white shadow-sm hover:shadow-md hover:border-pink-300 transition cursor-pointer">
                    <input type="checkbox"
                           id="enable_color"
                           name="enable_color"
                           value="1"
                           class="personalization-toggle sr-only"
                           data-target="config-color"
                           {{ old('enable_color', $colorField ? 1 : 0) ? 'checked' : '' }}>

                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="w-11 h-11 rounded-2xl bg-pink-100 text-pink-600 flex items-center justify-center text-lg">
                            🎨
                        </div>

                        <div class="flex items-center gap-2">
                            <span id="status-color" class="text-xs font-medium text-gray-400 transition">
                                Inactivo
                            </span>

                            <div class="relative w-11 h-6 bg-gray-200 rounded-full transition switch-track">
                                <span class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full transition-transform switch-thumb"></span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-800 text-base">Color</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Permite que el cliente elija el color disponible del producto.
                        </p>
                    </div>

                    <div class="mt-4">
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium bg-pink-50 text-pink-700 border border-pink-100">
                            Selección única
                        </span>
                    </div>

                    <div class="absolute inset-0 rounded-2xl ring-2 ring-transparent pointer-events-none transition card-ring"></div>
                </label>

                {{-- EXTRAS --}}
                <label class="relative border border-pink-200 rounded-2xl p-5 bg-white shadow-sm hover:shadow-md hover:border-pink-300 transition cursor-pointer">
                    <input type="checkbox"
                           id="enable_extras"
                           name="enable_extras"
                           value="1"
                           class="personalization-toggle sr-only"
                           data-target="extras-section"
                           {{ old('enable_extras', !empty($selectedExtras)) ? 'checked' : '' }}>

                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="w-11 h-11 rounded-2xl bg-pink-100 text-pink-600 flex items-center justify-center text-lg">
                            🎁
                        </div>

                        <div class="flex items-center gap-2">
                            <span id="status-extras" class="text-xs font-medium text-gray-400 transition">
                                Inactivo
                            </span>

                            <div class="relative w-11 h-6 bg-gray-200 rounded-full transition switch-track">
                                <span class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full transition-transform switch-thumb"></span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-800 text-base">Productos extras</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Permite que el cliente agregue complementos al producto.
                        </p>
                    </div>

                    <div class="mt-4">
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium bg-pink-50 text-pink-700 border border-pink-100">
                            Complementos
                        </span>
                    </div>

                    <div class="absolute inset-0 rounded-2xl ring-2 ring-transparent pointer-events-none transition card-ring"></div>
                </label>
            </div>

            {{-- CONFIGURACIÓN DETALLADA --}}
            <div class="space-y-4">
                <div id="config-dedicatoria" class="hidden border rounded-xl p-4 bg-white">
                    <h3 class="font-semibold mb-3 text-gray-800">Configuración dedicatoria</h3>

                    <label class="block text-sm font-medium text-gray-700 mb-1">Límite de caracteres</label>
                    <input type="number"
                           name="dedicatoria_max"
                           class="w-full border rounded-lg px-3 py-2"
                           placeholder="120"
                           value="{{ old('dedicatoria_max', $dedicatoriaField->max_length ?? 120) }}">

                    <label class="flex items-center gap-2 mt-4">
                        <input type="checkbox"
                               name="dedicatoria_required"
                               value="1"
                               {{ old('dedicatoria_required', $dedicatoriaField->is_required ?? 0) ? 'checked' : '' }}>
                        <span class="text-sm">Obligatorio</span>
                    </label>
                </div>

                <div id="config-foto" class="hidden border rounded-xl p-4 bg-white">
                    <h3 class="font-semibold mb-3 text-gray-800">Configuración foto</h3>

                    <label class="block text-sm font-medium text-gray-700 mb-1">Formatos permitidos</label>
                    <input type="text"
                           value="JPG, PNG"
                           class="w-full border rounded-lg px-3 py-2 bg-gray-50"
                           disabled>

                    <label class="flex items-center gap-2 mt-4">
                        <input type="checkbox"
                               name="foto_required"
                               value="1"
                               {{ old('foto_required', $fotoField->is_required ?? 0) ? 'checked' : '' }}>
                        <span class="text-sm">Obligatorio</span>
                    </label>
                </div>

                <div id="config-color" class="hidden border rounded-xl p-4 bg-white">
                    <h3 class="font-semibold mb-3 text-gray-800">Opciones de color</h3>

                    @if(isset($colors) && $colors->count())
                        <div class="flex gap-2 flex-wrap">
                            @foreach($colors as $color)
                                <div class="border px-3 py-2 rounded-lg text-sm bg-white">
                                    {{ $color->nombre ?? 'Color' }}
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-400">Este producto no tiene colores configurados.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- IMAGEN BASE DEL PRODUCTO --}}
        <div class="bg-white border border-pink-100 rounded-2xl p-6 shadow-sm">
            <h2 class="font-bold mb-4 text-gray-800">Imagen base del producto</h2>

            <p class="text-sm text-gray-600 mb-4">
                Esta imagen principal servirá como base para la vista del cliente en la pantalla de personalización.
            </p>

            <div class="mt-4 border rounded-xl bg-pink-50 overflow-hidden p-4 flex items-center justify-center min-h-[260px]">
                @if($product->imagen_principal)
                    <img
                        src="{{ asset('storage/' . $product->imagen_principal) }}"
                        alt="{{ $product->nombre }}"
                        class="max-h-[280px] w-auto max-w-full object-contain rounded-lg">
                @else
                    <span class="text-gray-400 text-sm">Este producto aún no tiene imagen principal.</span>
                @endif
            </div>
        </div>

        {{-- CONFIGURACIÓN AVANZADA (OPCIONAL) --}}
        <div id="advanced-config-card"
             class="rounded-2xl border-2 border-dashed border-pink-200 bg-white opacity-80 transition-all duration-300 shadow-sm">

            <button type="button"
                    id="advanced-config-toggle"
                    class="w-full flex items-center justify-between px-6 py-5 text-left rounded-2xl">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center text-pink-600 text-lg">
                        ⚙️
                    </div>

                    <div>
                        <h2 class="font-bold text-gray-800">
                            Configuración avanzada <span class="text-gray-500 font-normal">(opcional)</span>
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Solo úsala si necesitas crear un campo especial adicional.
                        </p>
                    </div>
                </div>

                <svg id="advanced-config-icon"
                     xmlns="http://www.w3.org/2000/svg"
                     class="w-6 h-6 text-gray-500 transition-transform duration-300"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div id="advanced-config-body" class="hidden px-6 pb-6">
                <div class="border-t border-pink-100 pt-6 space-y-6">

                    <div class="rounded-xl bg-pink-50 border border-pink-100 px-4 py-3">
                        <p class="text-sm text-pink-700">
                            Esta sección es solo para casos especiales. Dedicatoria, foto, color y extras ya se configuran arriba.
                        </p>
                    </div>

                    {{-- OPCIONES RÁPIDAS --}}
                    <div class="bg-white rounded-2xl border border-pink-100 p-5 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Opciones rápidas</h3>
                        <p class="text-sm text-gray-500 mb-4">
                            Sirven para crear campos rápido, pero ya no son lo principal.
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3">
                            <button type="button"
                                    class="preset-btn text-left border border-pink-200 rounded-xl p-4 hover:bg-pink-50 transition focus:outline-none focus:ring-2 focus:ring-pink-200"
                                    data-preset="dedicatoria">
                                <div class="font-semibold text-gray-800">Dedicatoria en tarjeta</div>
                                <div class="text-xs text-gray-500 mt-1">Permite texto corto o texto largo</div>
                            </button>

                            <button type="button"
                                    class="preset-btn text-left border border-pink-200 rounded-xl p-4 hover:bg-pink-50 transition focus:outline-none focus:ring-2 focus:ring-pink-200"
                                    data-preset="foto">
                                <div class="font-semibold text-gray-800">Foto del cliente</div>
                                <div class="text-xs text-gray-500 mt-1">Permite subir una imagen</div>
                            </button>

                            <button type="button"
                                    class="preset-btn text-left border border-pink-200 rounded-xl p-4 hover:bg-pink-50 transition focus:outline-none focus:ring-2 focus:ring-pink-200"
                                    data-preset="color">
                                <div class="font-semibold text-gray-800">Selección de color</div>
                                <div class="text-xs text-gray-500 mt-1">Permite elegir una sola opción</div>
                            </button>
                        </div>
                    </div>

                    {{-- INFORMACIÓN BÁSICA --}}
                    <div class="bg-white rounded-2xl border border-pink-100 p-5 shadow-sm">
                        <h3 class="font-semibold text-gray-800 mb-4">Información básica</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    ¿Qué podrá personalizar el cliente?
                                </label>
                                <input type="text"
                                       name="label"
                                       id="field_label"
                                       value="{{ old('label') }}"
                                       placeholder="Ej. Frase en globo"
                                       class="w-full border border-pink-100 rounded-xl px-3 py-2">
                                <p class="text-xs text-gray-400 mt-1">
                                    Este será el nombre visible para el cliente.
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    ¿Cómo lo completará el cliente?
                                </label>
                                <select name="type"
                                        id="field_type"
                                        class="w-full border border-pink-100 rounded-xl px-3 py-2">
                                    <option value="">Selecciona una opción rápida primero</option>
                                </select>
                                <p class="text-xs text-gray-400 mt-1" id="field_type_help">
                                    Elige primero una opción rápida para mostrar solo tipos válidos.
                                </p>
                            </div>

                            <div id="max-length-wrapper">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Límite de texto
                                </label>
                                <input type="number"
                                       name="max_length"
                                       id="field_max_length"
                                       value="{{ old('max_length') }}"
                                       placeholder="Ej. 120"
                                       class="w-full border border-pink-100 rounded-xl px-3 py-2">
                                <p class="text-xs text-gray-400 mt-1">
                                    Solo aplica para campos de texto.
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div id="selection-config-wrapper" class="hidden">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Forma de selección
                                </label>
                                <select name="selection_type"
                                        id="field_selection_type"
                                        class="w-full border border-pink-100 rounded-xl px-3 py-2">
                                    <option value="">Selecciona una opción</option>
                                    <option value="single" {{ old('selection_type') === 'single' ? 'selected' : '' }}>Una sola opción</option>
                                    <option value="multiple" {{ old('selection_type') === 'multiple' ? 'selected' : '' }}>Varias opciones</option>
                                </select>
                                <p class="text-xs text-gray-400 mt-1">
                                    Solo aplica cuando el cliente debe elegir entre varias alternativas.
                                </p>
                            </div>

                            <div class="flex items-end">
                                <label class="flex items-center gap-2 text-sm text-gray-700">
                                    <input type="checkbox"
                                           name="is_required"
                                           id="field_is_required"
                                           value="1"
                                           {{ old('is_required') ? 'checked' : '' }}>
                                    ¿Este dato es obligatorio?
                                </label>
                            </div>
                        </div>

                        <div class="mt-5">
                            <button type="submit"
                                    name="accion"
                                    value="agregar_campo"
                                    class="bg-pink-600 text-white px-4 py-2 rounded-xl hover:bg-pink-700 transition">
                                Agregar campo
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- EXTRAS DISPONIBLES PARA ESTE PRODUCTO --}}
        <div id="extras-section" class="hidden bg-white border border-pink-100 rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between gap-3 mb-4">
                <div>
                    <h2 class="font-bold text-gray-800">Extras disponibles para este producto</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Selecciona los extras del catálogo que el cliente podrá agregar a este producto.
                    </p>
                </div>

                <a href="{{ route('admin.extras.index') }}"
                   class="px-4 py-2 border border-pink-200 rounded-xl hover:bg-pink-50 text-sm transition">
                    Ver catálogo de extras
                </a>
            </div>

            @if(isset($extras) && $extras->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($extras as $extra)
                        <label class="flex items-start gap-3 border rounded-xl p-4 hover:bg-pink-50 cursor-pointer transition">
                            <input type="checkbox"
                                   name="extras[]"
                                   value="{{ $extra->id }}"
                                   class="mt-1"
                                   {{ in_array($extra->id, old('extras', $selectedExtras ?? [])) ? 'checked' : '' }}>

                            <div class="flex-1">
                                <div class="flex items-start gap-3">
                                    @if(!empty($extra->imagen))
                                        <img
                                            src="{{ asset('storage/' . $extra->imagen) }}"
                                            alt="{{ $extra->nombre }}"
                                            class="w-16 h-16 object-cover rounded-lg border">
                                    @else
                                        <div class="w-16 h-16 rounded-lg border bg-gray-50 flex items-center justify-center text-xs text-gray-400">
                                            Sin imagen
                                        </div>
                                    @endif

                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $extra->nombre }}</p>

                                        @if(!empty($extra->tipo))
                                            <p class="text-xs text-gray-400">{{ $extra->tipo }}</p>
                                        @endif

                                        @if(!empty($extra->descripcion))
                                            <p class="text-sm text-gray-500 mt-1">{{ $extra->descripcion }}</p>
                                        @endif

                                        <p class="text-sm text-pink-600 font-semibold mt-2">
                                            +${{ number_format($extra->precio_adicional, 2) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            @else
                <div class="text-sm text-gray-500 border border-dashed rounded-xl p-4">
                    Aún no hay extras activos en el catálogo.
                </div>
            @endif
        </div>

        {{-- BOTONES --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.products.index') }}"
               class="border px-4 py-2 rounded-xl hover:bg-pink-50 transition">
                Cancelar
            </a>

            <button type="submit"
                    name="accion"
                    value="guardar_configuracion"
                    class="bg-pink-600 text-white px-6 py-2 rounded-xl hover:bg-pink-700 transition">
                Guardar cambios
            </button>
        </div>
    </form>

    {{-- CAMPOS EXISTENTES --}}
    <div class="bg-white border border-pink-100 rounded-2xl p-6 shadow-sm">
        <h2 class="font-bold mb-4 text-gray-800">Campos creados</h2>

        @forelse($fields ?? [] as $field)
            <div class="border rounded-xl p-4 mb-4">
                <div class="flex justify-between items-start gap-4">
                    <div class="space-y-1">
                        <h3 class="font-semibold text-gray-800">{{ $field->label }}</h3>

                        <p class="text-sm text-gray-500">
                            Tipo:
                            <span class="font-medium">
                                @switch($field->type)
                                    @case('text') Texto corto @break
                                    @case('textarea') Texto largo @break
                                    @case('select') Lista desplegable @break
                                    @case('checkbox') Selección múltiple @break
                                    @case('radio') Selección única @break
                                    @case('image') Subir imagen @break
                                    @default {{ $field->type }}
                                @endswitch
                            </span>
                        </p>

                        <p class="text-xs text-gray-400">
                            {{ $field->is_required ? 'Obligatorio' : 'Opcional' }}
                        </p>

                        @if(!empty($field->help_text))
                            <p class="text-xs text-gray-500">
                                Ayuda interna: {{ $field->help_text }}
                            </p>
                        @endif
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('admin.products.personalization.option.edit', [$product->id, $field->id]) }}"
                           class="border px-3 py-1 rounded-lg text-sm hover:bg-pink-50 transition">
                            Editar
                        </a>

                        <form action="{{ route('admin.products.personalization.option.destroy', [$product->id, $field->id]) }}"
                              method="POST"
                              onsubmit="return confirm('¿Deseas eliminar este campo?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="text-red-500 text-sm border border-red-200 px-3 py-1 rounded-lg hover:bg-red-50 transition">
                                Eliminar campo
                            </button>
                        </form>
                    </div>
                </div>

                @if(in_array($field->type, ['select', 'checkbox', 'radio']))
                    <div class="mt-4">
                        <div class="bg-pink-50 border border-pink-100 rounded-xl p-4 mb-3 text-sm text-gray-600">
                            Aquí agregas las opciones que podrá elegir el cliente en este campo.
                            <br>
                            <span class="text-gray-500">
                                Ejemplo: si el campo es "Color", aquí puedes crear opciones como Rojo, Rosado o Blanco.
                            </span>
                        </div>

                        <form action="{{ route('admin.products.personalization.fields.options.store', [$product->id, $field->id]) }}"
                              method="POST"
                              class="grid grid-cols-1 md:grid-cols-4 gap-2 mb-3">
                            @csrf

                            <input type="text"
                                   name="option_label"
                                   value="{{ old('option_label') }}"
                                   placeholder="Nombre de la opción"
                                   class="border px-3 py-2 rounded-lg">

                            <input type="number"
                                   name="option_extra_price"
                                   value="{{ old('option_extra_price') }}"
                                   step="0.01"
                                   placeholder="Precio extra"
                                   class="border px-3 py-2 rounded-lg">

                            <input type="number"
                                   name="option_stock"
                                   value="{{ old('option_stock') }}"
                                   placeholder="Stock"
                                   class="border px-3 py-2 rounded-lg">

                            <button type="submit"
                                    class="bg-pink-600 text-white px-3 py-2 rounded-lg hover:bg-pink-700 transition">
                                Agregar opción
                            </button>
                        </form>

                        @forelse($field->options ?? [] as $option)
                            <div class="flex justify-between items-center border rounded-lg px-3 py-2 mb-2">
                                <div>
                                    {{ $option->label }}

                                    @if($option->extra_price > 0)
                                        <span class="text-pink-600 text-sm">
                                            (+${{ number_format($option->extra_price, 2) }})
                                        </span>
                                    @endif

                                    @if($option->controls_inventory)
                                        <span class="text-gray-500 text-sm">
                                            Stock: {{ $option->stock }}
                                        </span>
                                    @endif
                                </div>

                                <form action="{{ route('admin.products.personalization.fields.options.destroy', [$product->id, $field->id, $option->id]) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Deseas eliminar esta opción?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="text-red-500 text-sm">
                                        Eliminar opción
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="text-sm text-gray-500 border border-dashed rounded-xl p-4">
                                Este campo aún no tiene opciones registradas.
                            </div>
                        @endforelse
                    </div>
                @endif
            </div>
        @empty
            <div class="text-sm text-gray-500 border border-dashed rounded-xl p-4">
                Aún no se han creado campos de personalización para este producto.
            </div>
        @endforelse
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeField = document.getElementById('field_type');
    const labelField = document.getElementById('field_label');
    const maxLengthField = document.getElementById('field_max_length');
    const requiredField = document.getElementById('field_is_required');
    const selectionTypeField = document.getElementById('field_selection_type');
    const fieldTypeHelp = document.getElementById('field_type_help');

    const maxLengthWrapper = document.getElementById('max-length-wrapper');
    const selectionConfigWrapper = document.getElementById('selection-config-wrapper');

    const presetButtons = document.querySelectorAll('.preset-btn');

    const advancedToggle = document.getElementById('advanced-config-toggle');
    const advancedBody = document.getElementById('advanced-config-body');
    const advancedIcon = document.getElementById('advanced-config-icon');
    const advancedCard = document.getElementById('advanced-config-card');
    const personalizationToggles = document.querySelectorAll('.personalization-toggle');

    const presetOptions = {
        dedicatoria: {
            label: 'Dedicatoria',
            typeOptions: [
                { value: 'text', text: 'Texto corto' },
                { value: 'textarea', text: 'Texto largo' }
            ],
            defaultType: 'textarea',
            maxLength: '120',
            required: false,
            typeHelp: 'Para dedicatorias, solo se permiten tipos de texto.'
        },
        foto: {
            label: 'Foto del cliente',
            typeOptions: [
                { value: 'image', text: 'Subir imagen' }
            ],
            defaultType: 'image',
            maxLength: '',
            required: false,
            typeHelp: 'Para la foto del cliente, solo aplica subir imagen.'
        },
        color: {
            label: 'Color',
            typeOptions: [
                { value: 'radio', text: 'Selección única' }
            ],
            defaultType: 'radio',
            maxLength: '',
            required: false,
            typeHelp: 'Para color, el cliente debe elegir una sola opción.'
        }
    };

    function setTypeOptions(options, selectedValue = '') {
        if (!typeField) return;

        typeField.innerHTML = '';

        options.forEach(option => {
            const opt = document.createElement('option');
            opt.value = option.value;
            opt.textContent = option.text;

            if (selectedValue && selectedValue === option.value) {
                opt.selected = true;
            }

            typeField.appendChild(opt);
        });
    }

    function toggleByType() {
        if (!typeField) return;

        const type = typeField.value;

        if (type === 'text' || type === 'textarea') {
            maxLengthWrapper.classList.remove('hidden');
        } else {
            maxLengthWrapper.classList.add('hidden');
            if (maxLengthField) maxLengthField.value = '';
        }

        if (type === 'select' || type === 'checkbox' || type === 'radio') {
            selectionConfigWrapper.classList.remove('hidden');
        } else {
            selectionConfigWrapper.classList.add('hidden');
            if (selectionTypeField) {
                selectionTypeField.value = '';
            }
        }

        if (type === 'radio' && selectionTypeField) {
            selectionTypeField.value = 'single';
        }
    }

    function activatePresetButton(activeButton) {
        presetButtons.forEach(btn => {
            btn.classList.remove('ring-2', 'ring-pink-300', 'bg-pink-50', 'border-pink-400');
        });

        activeButton.classList.add('ring-2', 'ring-pink-300', 'bg-pink-50', 'border-pink-400');
    }

    presetButtons.forEach(button => {
        button.addEventListener('click', function () {
            activatePresetButton(this);

            const preset = this.dataset.preset;
            const config = presetOptions[preset];

            if (!config) return;

            if (labelField) labelField.value = config.label;
            setTypeOptions(config.typeOptions, config.defaultType);

            if (fieldTypeHelp) {
                fieldTypeHelp.textContent = config.typeHelp;
            }

            if (maxLengthField) maxLengthField.value = config.maxLength;
            if (requiredField) requiredField.checked = config.required;

            if (preset === 'color' && selectionTypeField) {
                selectionTypeField.value = 'single';
            }

            toggleByType();

            const infoSection = document.getElementById('field_label');
            if (infoSection) {
                infoSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    });

    function updateCardState(input) {
        if (!input) return;

        const label = input.closest('label');
        if (!label) return;

        const status = label.querySelector('[id^="status-"]');
        const track = label.querySelector('.switch-track');
        const thumb = label.querySelector('.switch-thumb');
        const ring = label.querySelector('.card-ring');

        if (input.checked) {
            label.classList.add('border-pink-300', 'bg-pink-50');
            label.classList.remove('border-pink-200', 'bg-white');

            if (status) {
                status.textContent = 'Activo';
                status.classList.remove('text-gray-400');
                status.classList.add('text-green-600');
            }

            if (track) {
                track.classList.remove('bg-gray-200');
                track.classList.add('bg-green-500');
            }

            if (thumb) {
                thumb.classList.add('translate-x-5');
            }

            if (ring) {
                ring.classList.remove('ring-transparent');
                ring.classList.add('ring-pink-300');
            }
        } else {
            label.classList.remove('border-pink-300', 'bg-pink-50');
            label.classList.add('border-pink-200', 'bg-white');

            if (status) {
                status.textContent = 'Inactivo';
                status.classList.remove('text-green-600');
                status.classList.add('text-gray-400');
            }

            if (track) {
                track.classList.remove('bg-green-500');
                track.classList.add('bg-gray-200');
            }

            if (thumb) {
                thumb.classList.remove('translate-x-5');
            }

            if (ring) {
                ring.classList.remove('ring-pink-300');
                ring.classList.add('ring-transparent');
            }
        }
    }

    function updateTargetVisibility(input) {
        if (!input) return;

        const targetId = input.dataset.target;
        if (!targetId) return;

        const target = document.getElementById(targetId);
        if (!target) return;

        if (input.checked) {
            target.classList.remove('hidden');
        } else {
            target.classList.add('hidden');
        }
    }

    if (advancedToggle && advancedBody && advancedIcon && advancedCard) {
        advancedToggle.addEventListener('click', function () {
            const isHidden = advancedBody.classList.contains('hidden');

            if (isHidden) {
                advancedBody.classList.remove('hidden');
                advancedIcon.classList.add('rotate-180');

                advancedCard.classList.remove('bg-white', 'opacity-80', 'border-dashed');
                advancedCard.classList.add('bg-pink-50', 'opacity-100', 'border-pink-200');
            } else {
                advancedBody.classList.add('hidden');
                advancedIcon.classList.remove('rotate-180');

                advancedCard.classList.remove('bg-pink-50', 'opacity-100', 'border-pink-200');
                advancedCard.classList.add('bg-white', 'opacity-80', 'border-dashed');
            }
        });
    }

    if (typeField) {
        typeField.addEventListener('change', toggleByType);
    }

    personalizationToggles.forEach(input => {
        updateCardState(input);
        updateTargetVisibility(input);

        input.addEventListener('change', function () {
            updateCardState(this);
            updateTargetVisibility(this);
        });
    });

    toggleByType();
});
</script>
@endsection
