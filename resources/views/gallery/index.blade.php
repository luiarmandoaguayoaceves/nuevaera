@extends('layouts.app')

@section('title','Galería | Calzado Nueva Era')

@section('content')
  {{-- Hero Section - Más moderno y estilizado --}}
  <section id="inicio" class="relative h-[60vh] flex items-center overflow-hidden">
    <img src="{{ asset('img/portada.webp') }}" alt="Colección Nueva Era" class="absolute inset-0 h-full w-full object-cover scale-105 transition-transform duration-1000">
    <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 to-slate-900/40"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
      <div class="max-w-2xl">
        <span class="inline-block px-3 py-1 rounded-full bg-rose-500/20 border border-rose-500/30 text-rose-400 text-xs font-bold uppercase tracking-widest mb-4">
            Hecho en México 🇲🇽
        </span>
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tighter text-white">
          Calzado <span class="text-rose-500">Nueva Era</span>
        </h1>
        <p class="mt-4 text-lg md:text-xl text-slate-200 leading-relaxed">
          Diseño contemporáneo y comodidad excepcional en cada paso. Descubre nuestra colección de temporada.
        </p>
        <div class="mt-8 flex gap-4">
          <a href="#galeria" class="rounded-xl bg-rose-600 px-8 py-4 text-sm font-bold text-white shadow-lg shadow-rose-900/20 hover:bg-rose-500 transition-all hover:-translate-y-1">
            Explorar Galería
          </a>
          <a href="#nosotros" class="rounded-xl bg-white/10 backdrop-blur-md px-8 py-4 text-sm font-bold text-white border border-white/20 hover:bg-white/20 transition-all">
            Nuestra Historia
          </a>
        </div>
      </div>
    </div>
  </section>

  {{-- Galería de Productos --}}
  <section id="galeria" class="py-20 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 mb-12">
        <div>
          <h2 class="text-3xl font-black text-slate-900 tracking-tight">Nuestra Colección</h2>
          <div class="h-1.5 w-20 bg-rose-600 mt-2 rounded-full"></div>
        </div>

        {{-- Filtros Estandarizados --}}
        <form id="filters" class="flex flex-wrap gap-3">
          <div class="relative flex-1 min-w-[200px]">
            <input id="q" type="text" placeholder="Buscar modelo..."
                   class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm focus:ring-rose-500 focus:border-rose-500 shadow-sm transition-all">
          </div>
          <select id="cat" class="rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 shadow-sm focus:ring-rose-500">
            <option value="">Todas las Categorías</option>
            @foreach($categorias as $c)
              @php $label = is_object($c) ? ($c->nombre ?? (string)$c) : $c; @endphp
              <option value="{{ $label }}">{{ ucfirst($label) }}</option>
            @endforeach
          </select>
          <select id="size" class="rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 shadow-sm focus:ring-rose-500">
            <option value="">Talla</option>
            @foreach($tallas as $t)
              <option>{{ $t }}</option>
            @endforeach
          </select>
        </form>
      </div>

      {{-- GRID de Productos --}}
      <div id="grid" class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach($productos as $p)
          {{-- Aquí estoy asumiendo que tu componente card ya tiene Tailwind --}}
          <x-product.card :product="$p" />
        @endforeach
      </div>

      {{-- Paginación personalizada --}}
      <div class="mt-16 py-8 border-t border-slate-200">
        {{ $productos->links() }}
      </div>
    </div>
  </section>

  {{-- Sobre Nosotros - Diseño Tipo Card --}}
  <section id="nosotros" class="py-24 bg-white">
    <div class="mx-auto max-w-5xl px-4 text-center">
      <div class="inline-flex items-center justify-center p-3 bg-rose-100 rounded-2xl mb-6">
          <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
      </div>
      <h2 class="text-4xl font-black text-slate-900 mb-6">Artesanos del Calzado</h2>
      <p class="text-lg text-slate-600 leading-relaxed mb-8">
        En <span class="font-bold text-slate-900 uppercase">Nueva Era</span>, fabricamos calzado para dama con materiales de alta calidad, combinando técnicas tradicionales con diseños modernos para la mujer de hoy.
      </p>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="p-6 rounded-2xl bg-slate-50">
              <span class="block text-3xl font-bold text-rose-600 mb-1">100%</span>
              <span class="text-sm font-bold text-slate-500 uppercase tracking-wide">Piel Genuina</span>
          </div>
          <div class="p-6 rounded-2xl bg-slate-50">
              <span class="block text-3xl font-bold text-rose-600 mb-1">+15 años</span>
              <span class="text-sm font-bold text-slate-500 uppercase tracking-wide">De Experiencia</span>
          </div>
          <div class="p-6 rounded-2xl bg-slate-50">
              <span class="block text-3xl font-bold text-rose-600 mb-1">Gdl</span>
              <span class="text-sm font-bold text-slate-500 uppercase tracking-wide">Orgullo Tapatío</span>
          </div>
      </div>
    </div>
  </section>

  {{-- Contacto - Estandarizado con el Admin --}}
  <section id="contacto" class="py-24 bg-slate-900 text-white relative overflow-hidden">
    {{-- Decoración de fondo --}}
    <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-96 h-96 bg-rose-600/20 rounded-full blur-3xl"></div>
    
    <div class="relative z-10 mx-auto max-w-7xl px-4 grid md:grid-cols-2 gap-12 items-center">
        <div>
            <h2 class="text-4xl font-black mb-6 italic">¿Tienes dudas?<br><span class="text-rose-500 not-italic">Contáctanos.</span></h2>
            <p class="text-slate-400 text-lg mb-8">Estamos listos para atenderte y ayudarte a encontrar el calzado perfecto para ti.</p>
            
            <div class="space-y-4">
                <a href="tel:+523331986670" class="flex items-center gap-4 group">
                    <div class="p-3 bg-white/10 rounded-xl group-hover:bg-rose-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <span class="text-xl font-bold">+52 333 198 6670</span>
                </a>
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-white/10 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <span class="text-slate-300 italic">Guadalajara, Jalisco, México</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white/5 backdrop-blur-sm border border-white/10 p-8 rounded-3xl">
            <h3 class="text-xl font-bold mb-4">Pregunta por nuestras redes</h3>
            {{-- <p class="text-slate-400 mb-6 text-sm">Próximamente podrás realizar tus pedidos directamente por nuestra tienda en línea.</p>
            <div class="flex gap-4">
                <div class="w-10 h-10 bg-rose-600 rounded-lg flex items-center justify-center font-bold">IG</div>
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center font-bold">FB</div>
                <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center font-bold">WA</div>
            </div> --}}
        </div>
    </div>
  </section>

  {{-- Componentes UI --}}
  <x-ui.lightbox />
  <x-ui.quick-view />
@endsection