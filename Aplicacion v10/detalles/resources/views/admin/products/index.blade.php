@extends('layouts.admin')
@section('title', 'Productos')

@section('content')
  <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between mb-6">
    <div>
      <h1 class="text-2xl font-extrabold text-gray-800">Productos</h1>
      <p class="text-sm text-gray-500">Gestiona tu catálogo con filtros y búsqueda</p>
    </div>

    <a href="{{ route('admin.products.create') }}"
       class="inline-flex items-center gap-2 bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-xl shadow-sm">
      <span class="text-lg">+</span>
      Nuevo Producto
    </a>
  </div>

  {{-- Filtros --}}
  <form method="GET" action="{{ route('admin.products.index') }}"
        class="bg-white/80 border border-pink-100 rounded-2xl p-4 shadow-sm mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-3">

      <div class="lg:col-span-2">
        <label class="text-xs font-semibold text-gray-600">Buscar</label>
        <input type="text" name="q" value="{{ request('q') }}"
               placeholder="Nombre o SKU..."
               class="mt-1 w-full rounded-xl border border-pink-200 bg-white px-3 py-2 outline-none focus:ring-2 focus:ring-pink-300">
      </div>

      <div>
        <label class="text-xs font-semibold text-gray-600">Estado</label>
        <select name="estado"
                class="mt-1 w-full rounded-xl border border-pink-200 bg-white px-3 py-2 outline-none focus:ring-2 focus:ring-pink-300">
          <option value="activos" @selected(request('estado','activos')==='activos')>Activos</option>
          <option value="borrador" @selected(request('estado')==='borrador')>Inactivos</option>
          <option value="todos" @selected(request('estado')==='todos')>Todos</option>
        </select>
      </div>

      <div>
        <label class="text-xs font-semibold text-gray-600">Orden</label>
        <select name="sort"
                class="mt-1 w-full rounded-xl border border-pink-200 bg-white px-3 py-2 outline-none focus:ring-2 focus:ring-pink-300">
          <option value="recent" @selected(request('sort','recent')==='recent')>Más recientes</option>
          <option value="name_asc" @selected(request('sort')==='name_asc')>Nombre A → Z</option>
          <option value="name_desc" @selected(request('sort')==='name_desc')>Nombre Z → A</option>
        </select>
      </div>

      <div>
        <label class="text-xs font-semibold text-gray-600">Tipo</label>
        <select name="tipo_producto"
                class="mt-1 w-full rounded-xl border border-pink-200 bg-white px-3 py-2 outline-none focus:ring-2 focus:ring-pink-300">
          <option value="">Todos</option>
          @foreach($catsTipoProducto as $c)
            <option value="{{ $c->id }}" @selected((string)request('tipo_producto')===(string)$c->id)>
              {{ $c->nombre }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- ✅ IMPORTANTE: el controller espera "ocasion" --}}
      <div>
        <label class="text-xs font-semibold text-gray-600">Ocasión</label>
        <select name="ocasion"
                class="mt-1 w-full rounded-xl border border-pink-200 bg-white px-3 py-2 outline-none focus:ring-2 focus:ring-pink-300">
          <option value="">Todas</option>
          @foreach($catsOcasion as $c)
            <option value="{{ $c->id }}" @selected((string)request('ocasion')===(string)$c->id)>
              {{ $c->nombre }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- ✅ IMPORTANTE: el controller espera "personalizacion" --}}
      <div>
        <label class="text-xs font-semibold text-gray-600">Personalización</label>
        <select name="personalizacion"
                class="mt-1 w-full rounded-xl border border-pink-200 bg-white px-3 py-2 outline-none focus:ring-2 focus:ring-pink-300">
          <option value="">Todas</option>
          @foreach($catsPersonal as $c)
            <option value="{{ $c->id }}" @selected((string)request('personalizacion')===(string)$c->id)>
              {{ $c->nombre }}
            </option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="flex items-center justify-end gap-2 mt-4">
      <a href="{{ route('admin.products.index') }}"
         class="px-4 py-2 rounded-xl border border-pink-200 bg-white hover:bg-pink-50">
        Limpiar
      </a>
      <button type="submit"
              class="px-4 py-2 rounded-xl bg-pink-600 hover:bg-pink-700 text-white shadow-sm">
        Aplicar filtros
      </button>
    </div>
  </form>

  {{-- Tabla --}}
  <div class="bg-white/80 border border-pink-100 rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full">
        <thead class="bg-white">
          <tr class="text-left text-sm text-gray-600">
            <th class="p-4 font-semibold">Nombre</th>
            <th class="p-4 font-semibold">SKU</th>
            <th class="p-4 font-semibold">Precio</th>
            <th class="p-4 font-semibold">Stock</th>
            <th class="p-4 font-semibold">Estado</th>
            <th class="p-4 font-semibold text-right">Acciones</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-pink-100">
          @forelse($products as $product)
            <tr class="hover:bg-pink-50/50">
              <td class="p-4 font-medium text-gray-800">{{ $product->nombre }}</td>
              <td class="p-4 text-gray-700">{{ $product->sku ?? '—' }}</td>
              <td class="p-4 text-gray-700">${{ number_format((float)$product->precio, 2) }}</td>
              <td class="p-4 text-gray-700">{{ $product->stock }}</td>
              <td class="p-4">
                @if($product->activo)
                  <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                    Activo
                  </span>
                @else
                  <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-200 text-gray-700">
                    Inactivo
                  </span>
                @endif
              </td>

              <td class="p-4 text-right whitespace-nowrap">
                <a href="{{ route('admin.products.edit', $product) }}"
                   class="inline-flex items-center px-3 py-1.5 rounded-xl border border-blue-100 bg-blue-50 text-blue-700 hover:bg-blue-100 mr-2">
                  Editar
                </a>

                {{-- ✅ ELIMINAR con MODAL GLOBAL --}}
<form id="deleteForm-{{ $product->id }}"
      action="{{ route('admin.products.destroy', $product) }}"
      method="POST"
      class="inline">
  @csrf
  @method('DELETE')

  <button type="button"
          data-confirm-submit="deleteForm-{{ $product->id }}"
          data-confirm-title="Confirmar eliminación"
          data-confirm-message="¿Está seguro que desea eliminar el producto: {{ e($product->nombre) }}? Esta acción no se puede deshacer."
          data-confirm-ok="Sí, eliminar"
          data-confirm-cancel="Cancelar"
          data-confirm-danger="1"
          class="text-red-600 hover:underline">
    Eliminar
  </button>
</form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="p-6 text-gray-600">
                No hay productos con esos filtros.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="p-4 border-t border-pink-100">
      {{ $products->links() }}
    </div>
  </div>
@endsection
