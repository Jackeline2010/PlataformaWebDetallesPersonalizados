@extends('layouts.client')

@section('title', 'SandyDecor - Mi perfil')

@section('content')

@php
  $user = $user ?? auth()->user();
  $client = $client ?? null;
  $orders = $orders ?? collect();

  $profile = $profile ?? [
      'nombre'         => optional($client)->nombres ?? optional($client)->nombre ?? $user->name ?? 'Usuario',
      'apellido'       => optional($client)->apellidos ?? optional($client)->apellido ?? '',
      'email'          => optional($client)->email ?? $user->email ?? '—',
      'telefono'       => optional($client)->telefono ?? ($user->telefono ?? null),
      'direccion'      => optional($client)->direccion ?? null,
      'genero'         => optional($client)->genero ?? null,
      'identificacion' => optional($client)->identificacion ?? null,
      'fnacimiento'    => optional($client)->fnacimiento ?? null,
      'activo'         => optional($client)->activo ?? true,
  ];

  $initial = strtoupper(mb_substr(($user->name ?? 'U'), 0, 1));
@endphp

<section class="bg-white/70 border border-pink-100 rounded-3xl p-6 shadow-sm antialiased md:p-8">

  {{-- Breadcrumb --}}
  <nav class="mb-4 flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2">
      <li class="inline-flex items-center">
        <a href="{{ route('client.dashboard') }}"
           class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-pink-700">
          🏠 Inicio
        </a>
      </li>

      <li aria-current="page">
        <div class="flex items-center">
          <span class="mx-2 text-gray-400">›</span>
          <span class="text-sm font-medium text-gray-500">Perfil</span>
        </div>
      </li>
    </ol>
  </nav>

  <h2 class="mb-6 text-xl font-semibold text-gray-900 sm:text-2xl">
    Perfil de Usuario
  </h2>

  {{-- Datos principales --}}
  <div class="py-4 md:py-6">

    <div class="mb-6 grid gap-6 sm:grid-cols-2 sm:gap-8 lg:gap-16">

      {{-- Columna izquierda --}}
      <div class="space-y-4">

        <div class="flex space-x-4">
          <div class="h-16 w-16 rounded-2xl border border-pink-100 bg-pink-50 flex items-center justify-center">
            <span class="text-2xl font-extrabold text-pink-700">{{ $initial }}</span>
          </div>

          <div>
            <span class="mb-2 inline-block rounded bg-pink-100 px-2.5 py-0.5 text-xs font-medium text-pink-800">
              Cuenta de Usuario
            </span>

            <h2 class="text-xl font-bold leading-none text-gray-900 sm:text-2xl">
              {{ trim(($profile['nombre'] ?? '') . ' ' . ($profile['apellido'] ?? '')) ?: 'Usuario' }}
            </h2>

            <p class="text-sm text-gray-500 mt-1">
              {{ $profile['email'] ?? '—' }}
            </p>
          </div>
        </div>

        <dl>
          <dt class="font-semibold text-gray-900">Género</dt>
          <dd class="text-gray-500">
            {{ $profile['genero'] ?: 'No registrado' }}
          </dd>
        </dl>

        <dl>
          <dt class="font-semibold text-gray-900">Dirección de Correo</dt>
          <dd class="text-gray-500">
            {{ optional($client)->email ?? ($user->email ?? '—') }}
          </dd>
        </dl>

        <dl>
          <dt class="font-semibold text-gray-900">Dirección de Entrega</dt>
          <dd class="flex items-center gap-1 text-gray-500">
            🚚
            {{ optional($client)->direccion ?? optional($orders->first())->direccion_entrega ?? 'No registrada' }}
          </dd>
        </dl>

      </div>

      {{-- Columna derecha --}}
      <div class="space-y-4">

        <dl>
          <dt class="font-semibold text-gray-900">Identificación</dt>
          <dd class="text-gray-500">
            {{ $profile['identificacion'] ?: 'No registrada' }}
          </dd>
        </dl>

        <dl>
          <dt class="font-semibold text-gray-900">Fecha de Nacimiento</dt>
          <dd class="text-gray-500">
            {{ $profile['fnacimiento']
                ? \Carbon\Carbon::parse($profile['fnacimiento'])->format('d/m/Y')
                : 'No registrada' }}
          </dd>
        </dl>

        <dl>
          <dt class="font-semibold text-gray-900">Teléfono Celular</dt>
          <dd class="text-gray-500">
            {{ $profile['telefono'] ?: 'No registrado' }}
          </dd>
        </dl>

        <dl>
          @php
            $activo = optional($client)->activo;
          @endphp

          @if(is_null($client))
            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold bg-gray-100 text-gray-700">
              Sin registro
            </span>
          @else
            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold
              {{ $activo ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
              {{ $activo ? 'Activo' : 'Inactivo' }}
            </span>
          @endif
        </dl>

      </div>
    </div>

    {{-- Botón editar --}}
    <button type="button"
            data-modal-toggle="accountInformationModal2"
            class="inline-flex w-full items-center justify-center rounded-2xl bg-pink-600 px-5 py-2.5 text-base font-semibold text-white hover:bg-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-200 sm:w-auto">
      ✏️ Editar Información
    </button>
  </div>

  {{-- Últimas órdenes --}}
  <div class="rounded-3xl border border-gray-200 bg-gray-50 p-4 md:p-6">
    <h3 class="mb-4 text-xl font-bold text-gray-900">Últimas órdenes</h3>

    @if($orders instanceof \Illuminate\Support\Collection ? $orders->count() : (isset($orders) && count($orders)))
      @foreach($orders as $order)

        @php
          $badge = match($order->estado) {
              'ING' => ['Ingresado',  'bg-gray-100 text-gray-700'],
              'PEN' => ['Pendiente',  'bg-orange-100 text-orange-700'],
              'PRO' => ['En proceso', 'bg-yellow-100 text-yellow-800'],
              'COM' => ['Completada', 'bg-green-100 text-green-700'],
              'CAN' => ['Cancelada',  'bg-red-100 text-red-700'],
              default => ['Desconocido','bg-gray-100 text-gray-700'],
          };
        @endphp

        <div class="flex flex-wrap items-center gap-y-4 border-b border-gray-200 py-4">
          <dl class="w-1/2 sm:w-48">
            <dt class="text-base font-medium text-gray-500">Orden:</dt>
            <dd class="mt-1.5 text-base font-semibold text-gray-900">
              #{{ $order->numero_orden ?? $order->id }}
            </dd>
          </dl>

          <dl class="w-1/2 sm:w-1/4 md:flex-1 lg:w-auto">
            <dt class="text-base font-medium text-gray-500">Fecha:</dt>
            <dd class="mt-1.5 text-base font-semibold text-gray-900">
              {{ optional($order->fpedido)->format('d/m/Y') ?? optional($order->created_at)->format('d/m/Y') }}
            </dd>
          </dl>

          <dl class="w-1/2 sm:w-1/5 md:flex-1 lg:w-auto">
            <dt class="text-base font-medium text-gray-500">Total:</dt>
            <dd class="mt-1.5 text-base font-semibold text-gray-900">
              ${{ number_format((float)($order->total ?? 0), 2) }}
            </dd>
          </dl>

          <dl class="w-1/2 sm:w-1/4 sm:flex-1 lg:w-auto">
            <dt class="text-base font-medium text-gray-500">Estado:</dt>
            <dd class="mt-1.5 inline-flex items-center rounded px-2.5 py-0.5 text-xs font-medium {{ $badge[1] }}">
              {{ $badge[0] }}
            </dd>
          </dl>

          <div class="w-full sm:flex sm:w-32 sm:items-center sm:justify-end">
            <a href="{{ route('client.orders.show', $order->id) }}"
               class="w-full md:w-auto text-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100">
              Ver detalle
            </a>
          </div>
        </div>

      @endforeach
    @else
      <p class="text-gray-500">Aún no tienes órdenes registradas.</p>
    @endif
  </div>

  {{-- MODAL: Editar Información --}}
  <div id="accountInformationModal2" tabindex="-1" aria-hidden="true"
       class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0 bg-black/30">

    <div class="relative w-full max-w-lg p-4">
      <div class="relative rounded-2xl bg-white shadow">

        <div class="flex items-center justify-between rounded-t border-b border-gray-200 p-4 md:p-5">
          <h3 class="text-lg font-semibold text-gray-900">Información de Cuenta</h3>

          <button type="button"
                  class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900"
                  data-modal-toggle="accountInformationModal2">
            ✕
            <span class="sr-only">Cerrar</span>
          </button>
        </div>

        <form method="POST" action="{{ route('client.profile.update') }}" class="p-4 md:p-5">
          @csrf

          <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-2">

            <div class="col-span-2 sm:col-span-1">
              <label class="mb-2 block text-sm font-medium text-gray-900">Identificación</label>
              <input type="text" name="identificacion"
                     value="{{ old('identificacion', optional($client)->identificacion) }}"
                     class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900"
                     placeholder="Ingrese su identificación">
            </div>

            <div class="col-span-2 sm:col-span-1">
              <label class="mb-2 block text-sm font-medium text-gray-900">Nombres</label>
              <input type="text" name="nombres"
                     value="{{ old('nombres', optional($client)->nombres) }}"
                     class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900"
                     placeholder="Ingrese sus nombres" required>
            </div>

            <div class="col-span-2 sm:col-span-1">
              <label class="mb-2 block text-sm font-medium text-gray-900">Apellidos</label>
              <input type="text" name="apellidos"
                     value="{{ old('apellidos', optional($client)->apellidos) }}"
                     class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900"
                     placeholder="Ingrese sus apellidos" required>
            </div>

            <div class="col-span-2 sm:col-span-1">
              <label class="mb-2 block text-sm font-medium text-gray-900">Correo</label>
              <input type="email" name="email"
                     value="{{ old('email', optional($client)->email ?? ($user->email ?? '')) }}"
                     class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900"
                     placeholder="Ingrese su email" required>
            </div>

            <div class="col-span-2 sm:col-span-1">
              <label class="mb-2 block text-sm font-medium text-gray-900">Fecha de Nacimiento</label>
              <input type="date" name="fnacimiento"
                     value="{{ old('fnacimiento', optional($client)->fnacimiento) }}"
                     class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900">
            </div>

            <div class="col-span-2 sm:col-span-1">
              <label class="mb-2 block text-sm font-medium text-gray-900">Género</label>
              <select name="genero"
                      class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900">
                <option value="">-- Seleccionar --</option>
                <option value="F" @selected(old('genero', optional($client)->genero) === 'F')>Femenino</option>
                <option value="M" @selected(old('genero', optional($client)->genero) === 'M')>Masculino</option>
                <option value="O" @selected(old('genero', optional($client)->genero) === 'O')>Otro</option>
              </select>
            </div>

            <div class="col-span-2">
              <label class="mb-2 block text-sm font-medium text-gray-900">Número de Celular</label>
              <input type="text" name="telefono"
                     value="{{ old('telefono', optional($client)->telefono) }}"
                     class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900"
                     placeholder="0999999999">
            </div>

            <div class="col-span-2">
              <label class="mb-2 block text-sm font-medium text-gray-900">Dirección de Entrega</label>
              <textarea name="direccion"
                        rows="3"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900"
                        placeholder="Ejemplo: Av. Universitaria y 10 de Agosto">{{ old('direccion', optional($client)->direccion) }}</textarea>
            </div>

          </div>

          <div class="border-t border-gray-200 pt-4 md:pt-5 flex justify-end gap-3">
            <button type="button" data-modal-toggle="accountInformationModal2"
                    class="rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-100">
              Cerrar
            </button>

            <button type="submit"
                    class="rounded-xl bg-pink-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-pink-700">
              Guardar
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>

</section>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('[data-modal-toggle]');

    buttons.forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();

        const id = btn.getAttribute('data-modal-toggle');
        const modal = document.getElementById(id);

        if (!modal) return;

        modal.classList.toggle('hidden');
        modal.classList.toggle('flex');
      });
    });

    const modal = document.getElementById('accountInformationModal2');

    if (modal) {
      modal.addEventListener('click', (e) => {
        if (e.target === modal) {
          modal.classList.add('hidden');
          modal.classList.remove('flex');
        }
      });
    }
  });
</script>
@endpush

@endsection
