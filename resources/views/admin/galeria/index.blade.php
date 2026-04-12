{{-- resources/views/admin/galeria/index.blade.php --}}
@extends('layouts.app')

@section('content')
  <!-- Cabecera del Admin con Botón de Logout -->
  <header class="flex flex-col md:flex-row items-center justify-between bg-white px-6 py-4 shadow-sm mb-8 rounded-xl border border-gray-100">
    <h1 class="text-xl font-bold text-gray-800 mb-4 md:mb-0">Panel de Administración - Galería</h1>
    
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="rounded-lg bg-red-500 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-red-600 transition-colors">
            Cerrar Sesión
        </button>
    </form>
  </header>

  {{-- ALERTAS --}}
  @if (session('ok'))
    <div class="mb-4 rounded-xl bg-green-50 border border-green-200 text-green-800 px-4 py-3">
      {{ session('ok') }}
    </div>
  @endif

  @if ($errors->any())
    <div class="mb-4 rounded-xl bg-red-50 border border-red-200 text-red-800 px-4 py-3">
      <p class="font-semibold">Revisa los campos:</p>
      <ul class="list-disc pl-5 mt-2 space-y-1">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- NUEVO PRODUCTO --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-10 overflow-hidden">
    <div class="bg-slate-50/50 border-b border-slate-200 px-6 py-5">
        <h2 class="text-lg font-bold text-slate-800">Agregar Nuevo Producto</h2>
        <p class="text-sm text-slate-500 mt-1">Completa los detalles a continuación para añadir un nuevo calzado al catálogo.</p>
    </div>

    <form action="{{ route('admin.galeria.producto.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        
        <div class="space-y-8">
            <!-- Sección 1: Información Básica -->
            <div>
                <h3 class="text-sm font-semibold text-slate-900 mb-4 flex items-center gap-2 uppercase tracking-wider">
                    <span class="w-8 h-[1px] bg-slate-200"></span>
                    1. Información General
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="nombre" class="block text-sm font-medium text-slate-700 mb-1">Nombre del producto <span class="text-red-500">*</span></label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required 
                               class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-colors sm:text-sm" placeholder="Ej. Tacón elegante negro">
                        @error('nombre') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="modelo" class="block text-sm font-medium text-slate-700 mb-1">Modelo / SKU <span class="text-red-500">*</span></label>
                        <input type="text" name="modelo" id="modelo" value="{{ old('modelo', $siguienteModelo ?? '') }}" required 
                               class="block w-full rounded-lg border-slate-300 bg-slate-50 shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-colors sm:text-sm font-medium text-slate-900">
                        @error('modelo') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="badge" class="block text-sm font-medium text-slate-700 mb-1">Etiqueta promocional</label>
                        <input type="text" name="badge" id="badge" value="{{ old('badge') }}" placeholder="Ej. Nuevo, Oferta..."
                               class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-colors sm:text-sm">
                        @error('badge') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="descripcion" class="block text-sm font-medium text-slate-700 mb-1">Descripción corta</label>
                        <textarea name="descripcion" id="descripcion" rows="2" 
                                  class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-colors sm:text-sm"
                                  placeholder="Describe las características principales del calzado...">{{ old('descripcion') }}</textarea>
                        @error('descripcion') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Sección 2: Organización y Precios -->
            <div>
                <h3 class="text-sm font-semibold text-slate-900 mb-4 flex items-center gap-2 uppercase tracking-wider">
                    <span class="w-8 h-[1px] bg-slate-200"></span>
                    2. Detalles de Venta
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="precio" class="block text-sm font-medium text-slate-700 mb-1">Precio ($)</label>
                        <div class="relative rounded-lg shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-slate-500 sm:text-sm font-medium">$</span>
                            </div>
                            <input type="number" step="0.01" min="0" name="precio" id="precio" value="{{ old('precio', 0) }}" placeholder="0.00"
                                   class="block w-full rounded-lg border-slate-300 pl-8 shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-colors sm:text-sm">
                        </div>
                        @error('precio') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-slate-700 mb-1">Categoría <span class="text-red-500">*</span></label>
                        <select name="category_id" id="category_id" required 
                                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-colors sm:text-sm bg-white">
                            <option value="" disabled selected>-- Seleccionar --</option>
                            @foreach($categorias as $c)
                                <option value="{{ $c->id }}" @selected(old('category_id') == $c->id)>
                                    {{ $c->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="tallas" class="block text-sm font-medium text-slate-700 mb-1">Tallas</label>
                        <input type="text" name="tallas" id="tallas" value="{{ old('tallas', '22,23,24') }}" placeholder="22, 23, 24..."
                               class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-colors sm:text-sm">
                        <p class="text-xs text-slate-500 mt-1.5">Separadas por comas (,)</p>
                        @error('tallas') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Sección 3: Multimedia y Estado -->
            <div>
                <h3 class="text-sm font-semibold text-slate-900 mb-4 flex items-center gap-2 uppercase tracking-wider">
                    <span class="w-8 h-[1px] bg-slate-200"></span>
                    3. Multimedia y Estado
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Área de Drag & Drop -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Imágenes de la galería</label>
                        <div class="mt-1 flex justify-center rounded-xl border border-dashed border-slate-300 px-6 py-8 hover:bg-slate-50 hover:border-slate-400 transition-all relative group">
                            <div class="text-center">
                                <svg class="mx-auto h-10 w-10 text-slate-300 group-hover:text-rose-400 transition-colors" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                </svg>
                                <div class="mt-4 flex text-sm leading-6 text-slate-600 justify-center">
                                    <label for="files" class="relative cursor-pointer rounded-md font-semibold text-rose-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-rose-600 focus-within:ring-offset-2 hover:text-rose-500">
                                        <span>Sube archivos</span>
                                        <input id="files" name="files[]" type="file" multiple accept="image/*" class="sr-only">
                                    </label>
                                    <p class="pl-1">o arrastra y suelta aquí</p>
                                </div>
                                <p class="text-xs leading-5 text-slate-400 mt-1">PNG, JPG, WEBP hasta 5MB</p>
                            </div>
                        </div>
                        @error('files.*') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="activo" class="block text-sm font-medium text-slate-700 mb-1">Estado en tienda <span class="text-red-500">*</span></label>
                        <div class="rounded-xl border border-slate-200 p-4 bg-slate-50/50">
                            <select name="activo" id="activo" required 
                                    class="block w-full rounded-lg border-slate-300 bg-white shadow-sm focus:border-rose-500 focus:ring-rose-500 transition-colors sm:text-sm mb-3 font-medium text-slate-700">
                                <option value="1" {{ old('activo', '1') == '1' ? 'selected' : '' }}>🟢 Publicado (Visible en tienda)</option>
                                <option value="0" {{ old('activo') == '0' ? 'selected' : '' }}>🔴 Oculto (Borrador)</option>
                            </select>
                            <p class="text-xs text-slate-500 leading-relaxed">Los productos ocultos no aparecerán en el catálogo público pero pueden ser editados en el panel en cualquier momento.</p>
                        </div>
                        @error('activo') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="mt-10 flex items-center justify-end gap-x-4 border-t border-slate-200 pt-6">
            <button type="reset" class="text-sm font-semibold leading-6 text-slate-500 hover:text-slate-800 transition-colors">
                Limpiar formulario
            </button>
            <button type="submit" class="rounded-lg bg-rose-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-rose-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-600 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Guardar Producto
            </button>
        </div>
    </form>
  </div>

  {{-- LISTA DE PRODUCTOS --}}
  @foreach ($productos as $p)
    @php
      $principal = $p->images->firstWhere('is_primary', true) ?? $p->images->sortBy('orden')->first();
    @endphp

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
      {{-- Encabezado --}}
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
          <div class="relative">
            @if ($principal)
              <img src="{{ $principal->url }}" alt="{{ $principal->alt }}" class="w-20 h-20 object-cover rounded-xl border">
              <span class="badge absolute top-1 left-1">Principal</span>
            @else
              <div class="w-20 h-20 rounded-xl bg-slate-100 grid place-items-center text-xs text-slate-500">Sin imagen</div>
            @endif
          </div>
          <div>
            <h3 class="font-semibold">{{ $p->modelo }} — {{ $p->nombre }}</h3>
            <p class="text-sm text-slate-500">ID: {{ $p->id }} • {{ $p->activo ? 'Activo' : 'Inactivo' }}</p>
          </div>
        </div>

        {{-- Toggle activo --}}
        <form method="POST" action="{{ route('admin.galeria.producto.toggle', $p) }}">
          @csrf @method('PATCH')
          <button type="submit" class="btn-muted {{ $p->activo ? 'bg-green-600 text-white hover:bg-green-700' : '' }}">
            {{ $p->activo ? 'Activo' : 'Inactivo' }}
          </button>
        </form>
      </div>

      {{-- Form editar producto --}}
      <form method="POST" action="{{ route('admin.galeria.producto.update', $p) }}" class="grid md:grid-cols-5 gap-6 mt-5">
        @csrf @method('PUT')

        {{-- PREVIEW --}}
        <div class="md:col-span-2 form-section">
          <p class="form-title">Vista previa</p>
          <div class="aspect-square rounded-xl overflow-hidden border bg-slate-50">
            @if ($principal)
              <img src="{{ $principal->url }}" alt="{{ $principal->alt }}" class="w-full h-full object-cover">
            @else
              <div class="w-full h-full grid place-items-center text-sm text-slate-500">Sin imagen</div>
            @endif
          </div>
          <div class="hint mt-2">{{ $principal?->alt ?? 'Sin texto alternativo' }}</div>
        </div>

        {{-- CAMPOS --}}
        <div class="md:col-span-3 grid gap-4">
          <div class="form-section">
            <p class="form-title">Básicos</p>
            <div class="grid md:grid-cols-2 gap-4">
              <div>
                <label class="label">Modelo</label>
                <input name="modelo" value="{{ old('modelo', $p->modelo) }}" required class="input" />
              </div>
              <div>
                <label class="label">Precio</label>
                <input type="number" step="0.01" min="0" name="precio" value="{{ old('precio', $p->precio) }}" class="input" />
              </div>
            </div>
            <label class="label mt-4">Nombre</label>
            <input name="nombre" value="{{ old('nombre', $p->nombre) }}" required class="input" />
            <label class="label mt-4">Descripción</label>
            <textarea name="descripcion" class="textarea">{{ old('descripcion', $p->descripcion) }}</textarea>
          </div>

          <div class="form-section">
            <p class="form-title">Clasificación</p>
            <div class="grid md:grid-cols-3 gap-4">
              <div>
                <label class="label">Tallas (coma)</label>
                <input name="tallas" value="{{ old('tallas', implode(',', $p->tallas ?? [])) }}" class="input" />
              </div>
              <div>
                <label class="label">Badge</label>
                <input name="badge" value="{{ old('badge', $p->badge) }}" class="input" />
              </div>
              <div>
                <label class="label">Categoría</label>
                <select name="category_id" class="select" required>
                  <option value="">— Selecciona —</option>
                  @foreach ($categorias as $c)
                    <option value="{{ $c->id }}" @selected($p->category_id === $c->id)>{{ $c->nombre }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <label class="label mt-4">Activo</label>
            <select name="activo" class="select">
              <option value="1" @selected($p->activo)>Sí</option>
              <option value="0" @selected(!$p->activo)>No</option>
            </select>

            <div class="mt-4">
              <button class="btn-primary">Guardar</button>
            </div>
          </div>
        </div>
      </form>

      {{-- SUBIR NUEVAS IMÁGENES --}}
      <div class="form-section mt-6">
        <p class="form-title">Agregar imágenes</p>
        <form method="POST" action="{{ route('admin.galeria.images.upload', $p) }}" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-3">
          @csrf
          <input type="file" name="files[]" multiple accept="image/*"
                 class="input file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-slate-200 file:text-slate-800 hover:file:bg-slate-300" required>
          <button class="btn-primary">Subir</button>
        </form>
      </div>

      {{-- GRID DE IMÁGENES (DnD + acciones) --}}
      <div id="grid-{{ $p->id }}" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6" data-product-id="{{ $p->id }}">
        @foreach($p->images->sortBy('orden') as $img)
          <div class="border rounded-xl overflow-hidden bg-white shadow-sm" draggable="true" data-image-id="{{ $img->id }}">
            <img src="{{ $img->url }}" alt="{{ $img->alt }}" class="w-full h-36 object-cover">
            <div class="p-3 space-y-2">

              {{-- ALT --}}
              <form method="POST" action="{{ route('admin.galeria.images.update', $img) }}" class="flex items-center gap-2">
                @csrf @method('PATCH')
                <input name="alt" value="{{ old('alt', $img->alt) }}" placeholder="Texto alternativo"
                       class="flex-1 rounded-lg border border-slate-300 text-sm px-2 py-1" />
                <button class="text-xs rounded-lg bg-slate-200 px-2 py-1 hover:bg-slate-300">Guardar</button>
              </form>

              {{-- REEMPLAZAR IMAGEN (solo admin) --}}
              <form method="POST" action="{{ route('admin.galeria.images.replace', $img) }}"
                    enctype="multipart/form-data" class="flex items-center gap-2">
                @csrf @method('PATCH')
                <input type="file" name="file" accept="image/*"
                       class="flex-1 text-sm file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-slate-200 file:text-slate-800 hover:file:bg-slate-300"
                       required>
                <button class="text-xs rounded-lg bg-blue-600 text-white px-2 py-1.5 hover:bg-blue-700">
                  Reemplazar
                </button>
              </form>

              <div class="flex items-center justify-between pt-1">
                {{-- Principal --}}
                <form method="POST" action="{{ route('admin.galeria.images.primary', $img) }}">
                  @csrf @method('PATCH')
                  <button class="text-xs {{ $img->is_primary ? 'text-green-700' : 'text-slate-600 hover:text-slate-900' }}">
                    {{ $img->is_primary ? 'Principal ✓' : 'Hacer principal' }}
                  </button>
                </form>

                {{-- Eliminar --}}
                <form method="POST" action="{{ route('admin.galeria.images.destroy', $img) }}" onsubmit="return confirm('¿Eliminar imagen?')">
                  @csrf @method('DELETE')
                  <button class="text-xs text-red-600 hover:underline">Eliminar</button>
                </form>
              </div>

            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endforeach

  {{-- Paginación --}}
  <div class="mt-6">
    {{ $productos->links() }}
  </div>
@endsection

{{-- Script DnD para ordenar imágenes --}}
<script>
  const galeriaImagesSortUrl = "{{ route('admin.galeria.images.sort') }}";

  (function () {
    const tokenEl = document.querySelector('meta[name="csrf-token"]');
    const token = tokenEl ? tokenEl.getAttribute('content') : '';

    document.querySelectorAll('[id^="grid-"]').forEach(setupGrid);

    function setupGrid(grid) {
      let dragged = null;

      grid.addEventListener('dragstart', (e) => {
        const card = e.target.closest('[data-image-id]');
        if (!card) return;
        dragged = card;
        card.classList.add('ring', 'ring-gray-300');
        e.dataTransfer.effectAllowed = 'move';
      });

      grid.addEventListener('dragover', (e) => {
        e.preventDefault();
        const over = e.target.closest('[data-image-id]');
        if (!dragged || !over || dragged === over) return;

        const rect = over.getBoundingClientRect();
        const before = (e.clientY - rect.top) < rect.height / 2;
        over.parentNode.insertBefore(dragged, before ? over : over.nextSibling);
      });

      grid.addEventListener('drop', async (e) => {
        e.preventDefault();
        if (dragged) {
          dragged.classList.remove('ring', 'ring-gray-300');
          dragged = null;
          await saveOrder(grid);
        }
      });

      grid.addEventListener('dragend', () => {
        if (dragged) dragged.classList.remove('ring', 'ring-gray-300');
        dragged = null;
      });
    }

    async function saveOrder(grid) {
      const productId = grid.getAttribute('data-product-id');
      const payload = Array.from(grid.querySelectorAll('[data-image-id]')).map((el, idx) => ({
        id: Number(el.getAttribute('data-image-id')),
        orden: idx + 1
      }));

      try {
        const res = await fetch(galeriaImagesSortUrl, {
          method: 'PATCH',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
          },
          body: JSON.stringify({ images: payload, product_id: productId })
        });

        if (!res.ok) throw new Error(await res.text());

        grid.classList.add('outline', 'outline-2', 'outline-green-300');
        setTimeout(() => grid.classList.remove('outline', 'outline-2', 'outline-green-300'), 600);
      } catch (err) {
        console.error(err);
        alert('No se pudo guardar el orden. Reintenta.');
      }
    }
  })();
</script>
