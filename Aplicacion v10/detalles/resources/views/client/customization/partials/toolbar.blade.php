@php
    use Illuminate\Support\Str;
@endphp

<div class="space-y-4">

    {{-- DEDICATORIA --}}
    @if(isset($dedicatoriaField) && $dedicatoriaField)
        <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-4">
            <div class="flex items-center justify-between gap-3 mb-3">
                <h2 class="text-lg font-semibold text-gray-800">
                    {{ $dedicatoriaField->label }}
                </h2>

                @if($dedicatoriaField->is_required)
                    <span class="text-xs text-red-500 font-medium">
                        Obligatorio
                    </span>
                @endif
            </div>

            <div>
                <textarea
                    id="input-dedicatoria"
                    rows="4"
                    maxlength="{{ $dedicatoriaField->max_length ?? 120 }}"
                    class="w-full rounded-xl border border-pink-100 px-3 py-2 focus:ring-2 focus:ring-pink-200 outline-none resize-none"
                    placeholder="Escribe aquí tu dedicatoria..."
                ></textarea>

                <div class="flex items-center justify-between mt-2">
                    <p class="text-xs text-gray-400">
                        Máximo {{ $dedicatoriaField->max_length ?? 120 }} caracteres
                    </p>

                    <span id="count-dedicatoria" class="text-xs text-gray-400">
                        0/{{ $dedicatoriaField->max_length ?? 120 }}
                    </span>
                </div>
            </div>
        </div>
    @endif

    {{-- COLOR --}}
    @if(isset($colorField) && $colorField && isset($colors) && $colors->count())
        <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-4">
            <div class="flex items-center justify-between gap-3 mb-3">
                <h2 class="text-lg font-semibold text-gray-800">
                    {{ $colorField->label }}
                </h2>

                <span id="selected-color-label" class="text-xs text-pink-600 font-medium">
                    Original
                </span>
            </div>

            <div class="flex flex-wrap gap-2">
                <button
                    type="button"
                    class="color-swatch px-3 py-2 rounded-xl border border-pink-200 bg-white text-sm font-medium text-pink-600 transition hover:bg-pink-50"
                    data-color=""
                    data-image="{{ asset('storage/' . $product->imagen_principal) }}"
                >
                    Original
                </button>

                @foreach($colors as $color)
                    <button
                        type="button"
                        class="color-swatch px-3 py-2 rounded-xl border border-pink-200 bg-white text-sm transition hover:bg-pink-50"
                        data-color="{{ $color->nombre }}"
                        data-image="{{ $color->imagen ? asset('storage/' . $color->imagen) : asset('storage/' . $product->imagen_principal) }}"
                    >
                        {{ $color->nombre }}
                    </button>
                @endforeach
            </div>

            <input type="hidden" id="selected-color" value="">
        </div>
    @endif

    {{-- FOTO DEL CLIENTE --}}
    @if(isset($fotoField) && $fotoField)
        <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-4">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">
                {{ $fotoField->label }}
            </h2>

            <input
                type="file"
                id="input-foto"
                accept="image/*"
                class="w-full text-sm text-gray-600 file:mr-3 file:px-4 file:py-2 file:rounded-xl file:border-0 file:bg-pink-600 file:text-white file:text-sm hover:file:bg-pink-700"
            >

            <p class="text-xs text-gray-400 mt-2">
                Sube una imagen clara para verla en la vista previa.
            </p>
        </div>
    @endif

    {{-- CAMPOS PERSONALIZADOS --}}
    @if(isset($customFields) && $customFields->count())
        <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-4">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                Personalización adicional
            </h2>

            <div class="space-y-4">
                @foreach($customFields as $field)
                    @if($field->type !== 'image')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $field->label }}
                                @if($field->is_required)
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>

                            @if($field->type === 'text')
                                <input
                                    type="text"
                                    class="w-full rounded-xl border border-pink-100 px-3 py-2 focus:ring-2 focus:ring-pink-200 outline-none"
                                >
                            @elseif($field->type === 'textarea')
                                <textarea
                                    rows="3"
                                    class="w-full rounded-xl border border-pink-100 px-3 py-2 focus:ring-2 focus:ring-pink-200 outline-none resize-none"
                                ></textarea>
                            @elseif(in_array($field->type, ['select', 'radio']))
                                <div class="flex flex-col gap-2">
                                    @foreach($field->options ?? [] as $option)
                                        <label class="flex items-center gap-2 text-sm text-gray-700">
                                            <input type="radio" value="{{ $option->id }}">
                                            {{ $option->label }}
                                        </label>
                                    @endforeach
                                </div>
                            @elseif($field->type === 'checkbox')
                                <div class="flex flex-col gap-2">
                                    @foreach($field->options ?? [] as $option)
                                        <label class="flex items-center gap-2 text-sm text-gray-700">
                                            <input type="checkbox" value="{{ $option->id }}">
                                            {{ $option->label }}
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endif

</div>
