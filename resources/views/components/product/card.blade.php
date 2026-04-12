{{-- resources/views/components/product/card.blade.php --}}
@props(['product'])

@php
    $primaryImage = $product->images->where('is_primary', true)->first() ?? $product->images->first();

    if ($primaryImage) {
        // Como ahora todo está en public/img, solo concatenamos asset('img/...')
        $img = asset('storage/' . $primaryImage->path);
    } else {
        $img = asset('img/placeholder.webp');
    }
@endphp



<li
    class="group relative flex flex-col overflow-hidden rounded-3xl bg-white border border-slate-200 shadow-sm transition-all hover:shadow-xl">

    {{-- Contenedor de Imagen --}}
    <div class="relative aspect-[4/5] w-full overflow-hidden bg-slate-100">
        {{-- En el src de tu imagen --}}
        <img src="{{ $img }}" alt="{{ $product->nombre }}" class="...">

        {{-- Badge --}}
        @if ($product->badge)
            <span
                class="absolute left-3 top-3 rounded-xl bg-rose-600 px-3 py-1.5 text-[10px] font-bold uppercase text-white shadow-lg">
                {{ $product->badge }}
            </span>
        @endif

        {{-- BOTÓN DE VISTA RÁPIDA (Ahora más visible) --}}
        <div
            class="absolute inset-x-0 bottom-0 p-4 translate-y-full transition-transform duration-300 group-hover:translate-y-0 bg-gradient-to-t from-black/60 to-transparent">
            <button onclick='openQuickView(@json($product->load('category', 'images')))'
                class="w-full rounded-xl bg-white py-2.5 text-xs font-bold text-slate-900 shadow-lg hover:bg-rose-600 hover:text-white transition-colors">
                VISTA RÁPIDA
            </button>
        </div>
    </div>

    {{-- Info --}}
    <div class="p-4 flex flex-col flex-1">
        <span class="text-[10px] font-bold uppercase tracking-widest text-rose-500 mb-1">
            {{ $product->category->nombre ?? 'Calzado' }}
        </span>
        <h3 class="text-base font-bold text-slate-900 mb-1">{{ $product->nombre }}</h3>

        <div class="flex items-center justify-between mt-auto pt-2">
            <p class="text-xs text-slate-500">Mod: <span class="font-mono text-slate-800">{{ $product->modelo }}</span>
            </p>
            <p class="text-lg font-black text-slate-900">${{ number_format($product->precio, 0) }}</p>
        </div>

        @if (!empty($tallas))
            <div class="mt-3 flex flex-wrap gap-1">
                @foreach (array_slice($tallas, 0, 4) as $t)
                    <span
                        class="h-6 w-6 flex items-center justify-center rounded-lg border border-slate-200 text-[10px] font-bold text-slate-600 bg-slate-50">
                        {{ $t }}
                    </span>
                @endforeach
            </div>
        @endif
    </div>
</li>
