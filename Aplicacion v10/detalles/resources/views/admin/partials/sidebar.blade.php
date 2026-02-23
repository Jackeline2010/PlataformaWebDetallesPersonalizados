<li x-data="{ open: {{ request()->routeIs('admin.categories.*') ? 'true' : 'false' }} }">

    {{-- PRODUCTOS --}}
    <div class="px-3 py-2 text-sm text-gray-500 uppercase">
        Catálogo
    </div>

    <button
        @click="open = !open"
        class="w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-pink-100 transition
        {{ request()->routeIs('admin.categories.*') ? 'bg-pink-200 text-pink-700' : '' }}">

        <div class="flex items-center gap-2">
            🎁 <span>Productos</span>
        </div>

        <svg class="w-4 h-4 transition"
             :class="open && 'rotate-90'"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    {{-- SUBMENU --}}
    <div x-show="open" class="ml-6 mt-2 space-y-1">

        <div class="text-xs text-gray-400 uppercase px-3">
            Categorías
        </div>

        @foreach($adminCategories as $cat)

            <a href="{{ route('admin.products.byCategory', $cat->id) }}"
               class="block px-4 py-2 rounded-lg text-sm transition
               {{ request()->route('category')?->id === $cat->id ? 'bg-pink-200 text-pink-700 font-semibold' : 'hover:bg-pink-100' }}">

                {{ $cat->nombre }}

            </a>

        @endforeach

    </div>
</li>
