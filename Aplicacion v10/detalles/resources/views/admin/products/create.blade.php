<form method="POST" action="{{ route('admin.products.store') }}">
    @csrf

    <div class="mb-3">
        <label class="block">Nombre *</label>
        <input type="text" name="nombre"
               class="w-full border p-2"
               required>
    </div>

    <div class="mb-3">
        <label class="block">Descripción corta</label>
        <textarea name="descripcion_corta"
                  class="w-full border p-2"></textarea>
    </div>

    <div class="mb-3">
        <label class="block">Precio *</label>
        <input type="number" step="0.01" name="precio"
               class="w-full border p-2" required>
    </div>

    <div class="mb-3">
        <label class="block">Stock *</label>
        <input type="number" name="stock"
               class="w-full border p-2" required>
    </div>

    <div class="mb-3">
        <label class="block">Categorías</label>
        <select name="categories[]" multiple class="w-full border p-2">
            @foreach($categories as $category)
                <option value="{{ $category->id }}">
                    {{ $category->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- CAMPOS OCULTOS CON VALORES POR DEFECTO --}}
    <input type="hidden" name="activo" value="1">
    <input type="hidden" name="destacado" value="0">
    <input type="hidden" name="personalizable" value="0">
    <input type="hidden" name="orden" value="0">

    <button class="bg-pink-600 text-white px-4 py-2 rounded">
        Guardar producto
    </button>
</form>
