@extends('layouts.admin')

@section('title','Panel de Administración')

@section('content')

<div class="p-6">

    <h1 class="text-4xl font-bold text-pink-400 mb-8 text-center">
        Panel de Administración
    </h1>

    {{-- CARDS SUPERIORES --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-blue-500">
            <p class="text-gray-500">Pedidos</p>
            <h2 class="text-3xl font-bold"><span class="counter" data-target="{{ $totalOrders }}">0</span>
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-green-500">
            <p class="text-gray-500">Ventas Totales</p>
        <h2 class="text-3xl font-bold">$ <span class="counter-money" data-target="{{ $totalSales ?? 0 }}">0.00</span>
        </h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-purple-500">
            <p class="text-gray-500">Clientes</p>
            <h2 class="text-3xl font-bold"><span class="counter" data-target="{{ $customers }}">0</span>
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-orange-500">
            <p class="text-gray-500">Productos Activos</p>
            <h2 class="text-3xl font-bold"><span class="counter" data-target="{{ $products }}">0</span>
            </h2>
        </div>

    </div>

    {{-- BLOQUES INFERIORES --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- ACTIVIDAD --}}
        <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold mb-3">Actividad reciente</h3>

     @if($recentOrders->count() == 0)
        <p class="text-gray-500">
            Aún no hay pedidos registrados.
        </p>
    @else
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b text-gray-500">
                    <th class="text-left py-2">Pedido</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>

            <tbody>
                @foreach($recentOrders as $order)
                <tr class="border-b">

                    <td class="py-2 font-semibold">
                        {{ $order->numero_orden }}
                    </td>

                    <td class="text-center">
                        $ {{ number_format($order->total,2) }}
                    </td>

                    <td class="text-center">
                        <span class="px-2 py-1 rounded text-white text-xs
                            @if($order->estado=='ING') bg-yellow-500
                            @elseif($order->estado=='PEN') bg-blue-500
                            @else bg-green-500
                            @endif">
                            {{ $order->estado }}
                        </span>
                    </td>

                    <td class="text-center">
                        {{ $order->created_at->format('d/m/Y') }}
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>


        {{-- ESTADO --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold mb-3">Estado del sistema</h3>

            <ul class="space-y-2 text-sm">

                <li class="flex items-center gap-2">
                    ✅ Sistema operativo
                </li>

                <li class="flex items-center gap-2">
                    ✅ Base de datos conectada
                </li>

                <li class="flex items-center gap-2">
                    ✅ Usuario administrador activo
                </li>

            </ul>
        </div>

    </div>

</div>
<script>
document.addEventListener('DOMContentLoaded', () => {

  // Contadores enteros (Pedidos, Clientes, Productos)
  document.querySelectorAll('.counter').forEach(el => {
    const target = parseInt(el.dataset.target || "0", 10);
    const duration = 900; // ms
    const start = 0;
    const startTime = performance.now();

    const step = (now) => {
      const progress = Math.min((now - startTime) / duration, 1);
      const value = Math.floor(start + (target - start) * progress);
      el.textContent = value.toLocaleString('es-EC');
      if (progress < 1) requestAnimationFrame(step);
    };

    requestAnimationFrame(step);
  });

  // Contador dinero (Ventas)
  document.querySelectorAll('.counter-money').forEach(el => {
    const target = parseFloat(el.dataset.target || "0");
    const duration = 1000; // ms
    const start = 0;
    const startTime = performance.now();

    const step = (now) => {
      const progress = Math.min((now - startTime) / duration, 1);
      const value = start + (target - start) * progress;
      el.textContent = value.toLocaleString('es-EC', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
      if (progress < 1) requestAnimationFrame(step);
    };

    requestAnimationFrame(step);
  });

});
</script>

@endsection
