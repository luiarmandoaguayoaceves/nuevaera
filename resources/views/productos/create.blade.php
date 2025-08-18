@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl p-6">
  <h1 class="mb-6 text-2xl font-bold">Nuevo producto</h1>

  <form method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <div>
      <label class="block text-sm font-medium">Modelo *</label>
      <input name="modelo" required class="mt-1 w-full rounded border-gray-300" />
      @error('modelo') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block text-sm font-medium">Nombre</label>
      <input name="nombre" class="mt-1 w-full rounded border-gray-300" />
    </div>

    <div>
      <label class="block text-sm font-medium">Categoría</label>
      <select name="category_id" class="mt-1 w-full rounded border-gray-300">
        <option value="">-- Selecciona --</option>
        @foreach($categorias as $c)
          <option value="{{ $c->id }}">{{ $c->nombre }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium">Tallas (mantén Ctrl para varias)</label>
      <select name="tallas[]" multiple size="6" class="mt-1 w-full rounded border-gray-300">
        @for($t=22; $t<=27; $t++)
          <option value="{{ $t }}">Talla {{ $t }}</option>
        @endfor
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium">Precio (MXN)</label>
      <input type="number" step=".01" name="precio" class="mt-1 w-full rounded border-gray-300" />
    </div>

    <div>
      <label class="block text-sm font-medium">Etiqueta (badge)</label>
      <input name="badge" class="mt-1 w-full rounded border-gray-300" placeholder="Nuevo, Oferta, etc."/>
    </div>

    <div>
      <label class="block text-sm font-medium">Descripción</label>
      <textarea name="descripcion" rows="4" class="mt-1 w-full rounded border-gray-300"></textarea>
    </div>

    <div>
      <label class="block text-sm font-medium">Imágenes (puedes subir varias)</label>
      <input type="file" name="imagenes[]" multiple accept="image/*" class="mt-1 w-full rounded border-gray-300" />
      <p class="mt-1 text-xs text-gray-500">La primera será la principal (puedes cambiarla).</p>
      <label class="mt-2 block text-sm">Índice de principal (0,1,2...)</label>
      <input type="number" name="principal" min="0" value="0" class="mt-1 w-24 rounded border-gray-300" />
    </div>

    <div class="pt-2">
      <button class="rounded bg-black px-4 py-2 text-white">Guardar</button>
      <a href="{{ route('productos.index') }}" class="ml-2 text-gray-600">Cancelar</a>
    </div>
  </form>
</div>
@endsection
