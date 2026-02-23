@extends('layouts.admin')

@section('title', 'Categorías')

@section('content')
<div class="p-6">

    {{-- Breadcrumb --}}
    <div class="text-sm text-gray-500 mb-2">
        Inicio › <span class="font-semibold text-gray-700">Categorías</span>
    </div>

    <h1 class="text-4xl font-semibold mb-6">Categorías</h1>

    {{-- Mensajes --}}
    @if(session('success'))
        <div id="flash-success"
             class="mb-4 p-4 rounded-2xl bg-green-50 text-green-700 border border-green-200 flex items-start justify-between gap-4">
            <div>{{ session('success') }}</div>
            <button type="button"
                    class="text-green-700/70 hover:text-green-900"
                    onclick="document.getElementById('flash-success')?.remove()">
                ✕
            </button>
        </div>
        <script>
            setTimeout(() => {
                const el = document.getElementById('flash-success');
                if (!el) return;
                el.style.transition = 'opacity .35s ease';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 350);
            }, 3500);
        </script>
    @endif

    @if($errors->any())
        <div class="mb-4 p-4 rounded-2xl bg-red-50 text-red-700 border border-red-200">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tabs --}}
    <div class="flex gap-4 mb-6">
        @foreach($types as $key => $label)
            <a href="{{ route('admin.categories.index', ['type' => $key]) }}"
               class="px-6 py-3 rounded-2xl border transition
               {{ $type === $key ? 'bg-pink-200 text-pink-700 border-pink-200' : 'bg-white hover:bg-gray-50' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-3xl shadow-sm border p-6">

        {{-- Top bar: botón + buscador + ordenar --}}
        <div class="flex flex-wrap gap-4 items-center mb-5">

            <button type="button"
                    onclick="openNewCategoryModal()"
                    class="px-6 py-3 rounded-2xl bg-pink-500 text-white font-semibold hover:bg-pink-600 transition">
                + Nueva Categoría
            </button>

            <form method="GET" class="flex flex-wrap gap-3 items-center ml-auto">
                <input type="hidden" name="type" value="{{ $type }}">

                <input name="search"
                       value="{{ $search }}"
                       placeholder="Buscar categorías..."
                       class="w-80 px-4 py-3 rounded-2xl border outline-none" />

                <select name="dir" class="px-4 py-3 rounded-2xl border">
                    <option value="asc"  {{ request('dir','asc')==='asc' ? 'selected' : '' }}>Nombre ASC</option>
                    <option value="desc" {{ request('dir')==='desc' ? 'selected' : '' }}>Nombre DESC</option>
                </select>

                <button class="px-5 py-3 rounded-2xl border hover:bg-gray-50 transition">Filtrar</button>
            </form>
        </div>

        {{-- Tabla --}}
        <div class="overflow-hidden rounded-2xl border">
            <table class="w-full">
                <thead class="bg-pink-50">
                    <tr>
                        <th class="text-left p-4">Nombre</th>
                        <th class="text-left p-4">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($categories as $cat)
                        <tr class="border-t">
                            <td class="p-4">
                                <div class="font-medium">{{ $cat->nombre }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ $cat->activo ? 'Activo' : 'Inactivo' }}
                                </div>
                            </td>

                            <td class="p-4">
                                <button type="button"
                                        class="text-pink-600 hover:underline mr-4"
                                        onclick="openEditCategoryModal(
                                            '{{ $cat->id }}',
                                            @js($cat->nombre),
                                            '{{ $cat->activo ? 1 : 0 }}'
                                        )">
                                    Editar
                                </button>

                                <form method="POST"
                                      action="{{ route('admin.categories.destroy', $cat->id) }}"
                                      class="inline"
                                      onsubmit="return confirm('¿Eliminar esta categoría?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-pink-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="p-6 text-center text-gray-500">
                                No hay categorías para este tipo.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
</div>

{{-- MODAL: NUEVA CATEGORÍA --}}
<div id="modal-new-category" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center p-4 z-50">
    <div class="bg-white w-full max-w-lg rounded-3xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold">Nueva Categoría</h2>
            <button type="button" class="text-gray-500" onclick="closeNewCategoryModal()">✕</button>
        </div>

        <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
            @csrf

            {{-- grupo actual (tipo_producto | ocasion | personalizacion) --}}
            <input type="hidden" name="grupo" value="{{ $type }}">

            <div>
                <label class="block text-sm text-gray-600 mb-1">Nombre</label>
                <input name="nombre" class="w-full px-4 py-3 rounded-2xl border" required>
            </div>

            <div class="flex items-center gap-2 mt-2">
                {{-- si se desmarca, igual se envía activo=0 --}}
                <input type="hidden" name="activo" value="0">
                <input id="activo_new" name="activo" type="checkbox" value="1" checked class="h-4 w-4">
                <label for="activo_new" class="text-sm text-gray-700">Activo</label>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" class="px-5 py-3 rounded-2xl border" onclick="closeNewCategoryModal()">
                    Cancelar
                </button>
                <button class="px-5 py-3 rounded-2xl bg-pink-500 text-white font-semibold hover:bg-pink-600">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL: EDITAR CATEGORÍA --}}
<div id="modal-edit-category" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center p-4 z-50">
    <div class="bg-white w-full max-w-lg rounded-3xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold">Editar Categoría</h2>
            <button type="button" class="text-gray-500" onclick="closeEditCategoryModal()">✕</button>
        </div>

        <form id="editCategoryForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Mantener el grupo/tab actual --}}
            <input type="hidden" name="grupo" value="{{ $type }}">

            <div>
                <label class="block text-sm text-gray-600 mb-1">Nombre</label>
                <input id="edit_nombre" name="nombre" class="w-full px-4 py-3 rounded-2xl border" required>
            </div>

            <div class="flex items-center gap-2 mt-2">
                {{-- si se desmarca, igual se envía activo=0 --}}
                <input type="hidden" name="activo" value="0">
                <input id="edit_activo" name="activo" type="checkbox" value="1" class="h-4 w-4">
                <label for="edit_activo" class="text-sm text-gray-700">Activo</label>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" class="px-5 py-3 rounded-2xl border" onclick="closeEditCategoryModal()">
                    Cancelar
                </button>
                <button class="px-5 py-3 rounded-2xl bg-pink-500 text-white font-semibold hover:bg-pink-600">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openNewCategoryModal() {
        document.getElementById('modal-new-category').classList.remove('hidden');
    }
    function closeNewCategoryModal() {
        document.getElementById('modal-new-category').classList.add('hidden');
    }

    function openEditCategoryModal(id, nombre, activo) {
        const modal = document.getElementById('modal-edit-category');
        const form  = document.getElementById('editCategoryForm');

        form.action = `{{ url('admin/categories') }}/${id}`;

        document.getElementById('edit_nombre').value = nombre || '';
        document.getElementById('edit_activo').checked = String(activo) === '1';

        modal.classList.remove('hidden');
    }
    function closeEditCategoryModal() {
        document.getElementById('modal-edit-category').classList.add('hidden');
    }
</script>
@endsection
