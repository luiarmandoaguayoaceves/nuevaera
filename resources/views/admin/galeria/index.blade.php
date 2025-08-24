{{-- admin/galeria/index.blade.php --}}
@extends('layouts.app')

@section('content')
@foreach ($productos as $p)
  <div class="bg-white rounded-2xl shadow p-6 mb-6">
    <h3 class="font-semibold mb-2">{{ $p->modelo }} — {{ $p->nombre }}</h3>

    {{-- Grid de imágenes con drag & drop --}}
    <div id="grid-{{ $p->id }}" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6"
         data-product-id="{{ $p->id }}">
      @foreach($p->images->sortBy('orden') as $img)
        <div class="border rounded-xl overflow-hidden bg-white shadow-sm"
             draggable="true"
             data-image-id="{{ $img->id }}">
          <img src="{{ $img->url }}" alt="{{ $img->alt }}" class="w-full h-36 object-cover">
          <div class="p-2 space-y-2">
            <form method="POST" action="{{ route('admin.galeria.images.update', $img) }}" class="flex items-center gap-2">
              @csrf @method('PATCH')
              <input name="alt" value="{{ old('alt', $img->alt) }}" placeholder="Texto alternativo"
                     class="flex-1 rounded-lg border-gray-300 text-sm" />
              <button class="text-xs rounded-lg bg-gray-200 px-2 py-1 hover:bg-gray-300">Guardar</button>
            </form>

            <div class="flex items-center justify-between">
              <form method="POST" action="{{ route('admin.galeria.images.primary', $img) }}">
                @csrf @method('PATCH')
                <button class="text-xs {{ $img->is_primary ? 'text-green-700' : 'text-gray-600 hover:text-gray-900' }}">
                  {{ $img->is_primary ? 'Principal ✓' : 'Hacer principal' }}
                </button>
              </form>

              <form method="POST" action="{{ route('admin.galeria.images.destroy', $img) }}"
                    onsubmit="return confirm('¿Eliminar imagen?')">
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
@endsection

{{-- Paginación --}}
{{ $productos->links() }}

{{-- Script DnD tal como lo tienes debajo --}}


<script>
(function () {
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

    try {
      const res = await fetch(`{{ route('admin.galeria.images.sort') }}`, {
        method: 'PATCH',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token,
          'Accept': 'application/json'
        },
        body: JSON.stringify({ images: payload, product_id: productId })
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
