<header class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b">
  <div class="mx-auto max-w-7xl px-4 py-3 flex items-center justify-between">
    <a href="{{ route('gallery.index') }}" class="flex items-center gap-3">
      <img src="{{ asset('img/logo.png') }}" alt="Nueva Era" class="w-10 h-10 rounded-lg shadow-sm">
      <span class="font-extrabold tracking-tight">Nueva Era</span>
    </a>
    <nav class="hidden md:flex items-center gap-6 text-sm">
      <a href="{{ route('gallery.index') }}#inicio" class="hover:text-rose-500">Inicio</a>
      <a href="{{ route('gallery.index') }}#galeria" class="hover:text-rose-500">Galería</a>
      <a href="{{ route('gallery.index') }}#nosotros" class="hover:text-rose-500">Nosotros</a>
      <a href="{{ route('gallery.index') }}#contacto" class="hover:text-rose-500">Contacto</a>
      @php $wa = config('services.whatsapp_sales'); @endphp
      @if($wa)
        <a href="https://wa.me/{{ $wa }}?text={{ urlencode('Hola, me interesa su catálogo') }}"
           target="_blank" class="inline-flex items-center gap-2 rounded-xl bg-black px-4 py-2 text-white hover:bg-gray-900">
          WhatsApp
        </a>
      @endif
    </nav>
  </div>
</header>
