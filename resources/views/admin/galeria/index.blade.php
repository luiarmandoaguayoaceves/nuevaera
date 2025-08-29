{{-- admin/galeria/index.blade.php --}}
@extends('layouts.app')

@section('content')
    {{-- NUEVO PRODUCTO --}}
    <div class="form-card mb-8">
        <h2 class="text-lg font-semibold mb-4">Nuevo producto</h2>

        <form method="POST" action="{{ route('admin.galeria.producto.store') }}" enctype="multipart/form-data"
            class="grid md:grid-cols-3 gap-4">
            @csrf

            <div class="form-section">
                <p class="form-title">Identificación</p>
                <label class="label">Modelo</label>
                <input name="modelo" value="{{ old('modelo', $siguienteModelo) }}" required class="input" />
                <p class="hint">Numeración o clave interna.</p>
            </div>

            <div class="md:col-span-2 form-section">
                <p class="form-title">Nombre y descripción</p>
                <label class="label">Nombre</label>
                <input name="nombre" value="{{ old('nombre') }}" required class="input" />
                <label class="label mt-4">Descripción</label>
                <textarea name="descripcion" rows="2" class="textarea">{{ old('descripcion') }}</textarea>
            </div>

            <div class="form-section">
                <p class="form-title">Precio</p>
                <label class="label">Precio</label>
                <input type="number" step="0.01" min="0" name="precio" value="{{ old('precio', 0) }}"
                    class="input" />
            </div>

            <div class="form-section">
                <p class="form-title">Tallas</p>
                <label class="label">Tallas (separadas por coma)</label>
                <input name="tallas" value="{{ old('tallas', '22,23,24') }}" class="input" />
            </div>

            <div class="form-section">
                <p class="form-title">Etiqueta</p>
                <label class="label">Badge</label>
                <input name="badge" value="{{ old('badge') }}" class="input" placeholder="Nuevo, Oferta..." />
            </div>

            <div class="form-section">
                <p class="form-title">Clasificación</p>
                <label class="label">Categoría</label>
                <select name="category_id" class="select">
                    <option value="">— Selecciona —</option>
                    @foreach ($categorias as $c)
                        <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                    @endforeach
                </select>

                <label class="label mt-4">Activo</label>
                <select name="activo" class="select">
                    <option value="1" selected>Sí</option>
                    <option value="0">No</option>
                </select>
            </div>

            <div class="md:col-span-2 form-section">
                <p class="form-title">Imágenes</p>
                <label class="label">Imágenes (opcional)</label>
                <input type="file" name="files[]" multiple accept="image/*"
                    class="input file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-slate-200 file:text-slate-800 hover:file:bg-slate-300">
                <p class="hint">JPG/PNG/WEBP/AVIF · máx 5 MB c/u</p>
            </div>

            <div class="md:col-span-3">
                <button class="btn-primary">Crear producto</button>
            </div>
        </form>
    </div>


    @foreach ($productos as $p)
        @php
            $principal = $p->images->firstWhere('is_primary', true) ?? $p->images->sortBy('orden')->first();
        @endphp

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        @if ($principal)
                            <img src="{{ $principal->url }}" alt="{{ $principal->alt }}"
                                class="w-20 h-20 object-cover rounded-xl border">
                            <span class="badge absolute top-1 left-1">Principal</span>
                        @else
                            <div class="w-20 h-20 rounded-xl bg-slate-100 grid place-items-center text-xs text-slate-500">
                                Sin imagen</div>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-semibold">{{ $p->modelo }} — {{ $p->nombre }}</h3>
                        <p class="text-sm text-slate-500">ID: {{ $p->id }} •
                            {{ $p->activo ? 'Activo' : 'Inactivo' }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.galeria.producto.toggle', $p) }}">
                    @csrf @method('PATCH')
                    <button type="submit"
                        class="btn-muted {{ $p->activo ? 'bg-green-600 text-white hover:bg-green-700' : '' }}">
                        {{ $p->activo ? 'Activo' : 'Inactivo' }}
                    </button>
                </form>
            </div>

            <form method="POST" action="{{ route('admin.galeria.producto.update', $p) }}"
                class="grid md:grid-cols-5 gap-6 mt-5">
                @csrf @method('PUT')

                {{-- PREVIEW --}}
                <div class="md:col-span-2 form-section">
                    <p class="form-title">Vista previa</p>
                    <div class="aspect-square rounded-xl overflow-hidden border bg-slate-50">
                        @if ($principal)
                            <img src="{{ $principal->url }}" alt="{{ $principal->alt }}"
                                class="w-full h-full object-cover">
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
                                <input type="number" step="0.01" min="0" name="precio"
                                    value="{{ old('precio', $p->precio) }}" class="input" />
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
                                <input name="tallas" value="{{ old('tallas', implode(',', $p->tallas ?? [])) }}"
                                    class="input" />
                            </div>
                            <div>
                                <label class="label">Badge</label>
                                <input name="badge" value="{{ old('badge', $p->badge) }}" class="input" />
                            </div>
                            <div>
                                <label class="label">Categoría</label>
                                <select name="category_id" class="select">
                                    <option value="">— Selecciona —</option>
                                    @foreach ($categorias as $c)
                                        <option value="{{ $c->id }}" @selected($p->category_id === $c->id)>
                                            {{ $c->nombre }}</option>
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
        </div>
    @endforeach
@endsection

{{-- Paginación --}}
{{ $productos->links() }}

{{-- Script DnD tal como lo tienes debajo --}}


<script>
    // Define the route URL using Blade outside the script logic
    const galeriaImagesSortUrl = "{{ route('admin.galeria.images.sort') }}";
    (function() {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Añade DnD a todos los grids de productos
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

                // Inserta antes o después según la posición del ratón
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
                id: parseInt(el.getAttribute('data-image-id')),
                orden: idx + 1
            }));

                const res = await fetch(galeriaImagesSortUrl, {
                const res = await fetch(galeriaImagesSortUrl, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        images: payload,
                        product_id: productId
                    })
                });
                if (!res.ok) throw new Error('Error al guardar el orden');
                // (Opcional) feedback visual
                grid.classList.add('outline', 'outline-2', 'outline-green-300');
                setTimeout(() => grid.classList.remove('outline', 'outline-2', 'outline-green-300'), 600);
            } catch (err) {
                alert('No se pudo guardar el orden. Reintenta.');
                console.error(err);
            }
        }
    })();
</script>
