{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-10">
  <div class="w-full max-w-md bg-white rounded-2xl shadow p-8 space-y-6">
    {{-- Encabezado / marca --}}
    <div class="text-center">
      {{-- Si tienes logo, reemplaza este H1 por <img src="{{ asset('...') }}" class="mx-auto h-10"> --}}
      <h1 class="text-2xl font-bold tracking-tight text-gray-900">Inicia sesión</h1>
      <p class="text-sm text-gray-500 mt-1">Panel para administrar la galería</p>
    </div>

    {{-- Mensajes globales --}}
    @if (session('status'))
      <div class="rounded-lg border border-blue-200 bg-blue-50 p-3 text-sm text-blue-700">
        {{ session('status') }}
      </div>
    @endif

    {{-- Errores de validación --}}
    @if ($errors->any())
      <div class="rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
        <ul class="list-disc list-inside space-y-1">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
      @csrf

      {{-- Email --}}
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Correo</label>
        <input
          id="email"
          name="email"
          type="email"
          value="{{ old('email') }}"
          required
          autofocus
          class="mt-1 block w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900"
          placeholder="tucorreo@dominio.com"
        />
        @error('email')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      {{-- Password con mostrar/ocultar --}}
      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
          {{-- Si implementas recuperación, coloca aquí el enlace --}}
          {{-- <a href="{{ route('password.request') }}" class="text-xs text-gray-600 hover:text-gray-900">¿Olvidaste tu contraseña?</a> --}}
        </div>

        <div class="mt-1 relative">
          <input
            id="password"
            name="password"
            type="password"
            required
            class="block w-full rounded-xl border-gray-300 pr-12 focus:border-gray-900 focus:ring-gray-900"
            placeholder="••••••••"
          />
          <button
            type="button"
            id="togglePassword"
            class="absolute inset-y-0 right-0 px-3 text-sm text-gray-600 hover:text-gray-900"
            aria-label="Mostrar u ocultar contraseña"
          >Mostrar</button>
        </div>
        @error('password')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      {{-- Remember me --}}
      <div class="flex items-center justify-between">
        <label class="inline-flex items-center gap-2 text-sm text-gray-600">
          <input type="checkbox" name="remember" class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
          Recuérdame
        </label>

        {{-- Enlace a galería pública --}}
        <a href="{{ route('gallery.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
          Ver galería pública
        </a>
      </div>

      {{-- Submit --}}
      <button
        type="submit"
        class="w-full rounded-xl bg-gray-900 px-4 py-2.5 text-white font-medium hover:bg-black transition"
      >
        Entrar
      </button>
    </form>

    <p class="text-center text-xs text-gray-500">
      Protegido por sesión y CSRF.
    </p>
  </div>
</div>

{{-- Pequeño script para mostrar/ocultar contraseña (sin dependencias) --}}
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('togglePassword');
    const input = document.getElementById('password');
    if (btn && input) {
      btn.addEventListener('click', () => {
        const isPwd = input.type === 'password';
        input.type = isPwd ? 'text' : 'password';
        btn.textContent = isPwd ? 'Ocultar' : 'Mostrar';
      });
    }
  });
</script>
@endsection
