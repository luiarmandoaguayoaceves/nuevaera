<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Calzado Nueva Era</title>

  <!-- Tailwind CDN + fuente -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui'] },
          colors: { brand: { DEFAULT: '#111827' }, accent: { DEFAULT: '#f43f5e' } }
        }
      }
    }
  </script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap">
</head>
<body class="min-h-full bg-white text-gray-700 antialiased">
  <!-- HEADER -->
  <header class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b">
    <div class="mx-auto max-w-7xl px-4 py-3 flex items-center justify-between">
      <a href="#inicio" class="flex items-center gap-3">
        <img src="/img/logo.png" alt="Logo Nueva Era" class="w-10 h-10 rounded-lg shadow-sm">
        <span class="font-extrabold tracking-tight">Nueva Era</span>
      </a>
      <nav class="hidden md:flex items-center gap-6 text-sm">
        <a href="#inicio" class="hover:text-accent">Inicio</a>
        <a href="#galeria" class="hover:text-accent">Galería</a>
        <a href="#nosotros" class="hover:text-accent">Nosotros</a>
        <a href="#contacto" class="hover:text-accent">Contacto</a>
        <a href="https://wa.me/5213312345678?text=Hola,%20quiero%20información%20de%20sus%20modelos"
           target="_blank" class="inline-flex items-center gap-2 rounded-xl bg-black px-4 py-2 text-white hover:bg-gray-900">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M20.52 3.48A11.94 11.94 0 0012.07 0 12 12 0 000 12.13 12 12 0 0018.3 22l.45.03h.03c.3 0 .58-.17.72-.43l1.52-2.98a.82.82 0 00-.16-.94 9.4 9.4 0 01-1.6-2.03.84.84 0 00-1.05-.35 7.6 7.6 0 01-3.28.72 7.59 7.59 0 01-7.57-7.57c0-4.18 3.4-7.57 7.58-7.57a7.6 7.6 0 017.58 7.58 7.62 7.62 0 01-.78 3.36.83.83 0 00.35 1.06 9.8 9.8 0 012.03 1.6.83.83 0 00.94.16l2.98-1.52a.84.84 0 00.43-.72v-.03A12 12 0 0020.52 3.48z"/></svg>
          WhatsApp
        </a>
      </nav>
    </div>
  </header>

  <main>
    <!-- HERO -->
    <section id="inicio" class="relative grid place-items-center h-[60vh]">
      <img src="/img/portada.webp" alt="Colección Nueva Era"
           class="absolute inset-0 h-full w-full object-cover">
      <div class="absolute inset-0 bg-black/60"></div>
      <div class="relative z-10 px-4 text-center text-white">
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight">Calzado Nueva Era</h1>
        <p class="mt-3 max-w-xl mx-auto text-white/90">Calidad, comodidad y estilo para cada día.</p>
        <div class="mt-6 flex justify-center gap-3">
          <a href="#galeria" class="rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-gray-900 shadow hover:bg-gray-100">Ver galería</a>
          <a href="#contacto" class="rounded-xl border border-white/50 px-5 py-2.5 text-sm font-semibold text-white hover:bg-white/10">Contáctanos</a>
        </div>
      </div>
    </section>

    <!-- GALERÍA / CATÁLOGO -->
    <section id="galeria" class="py-14">
      <div class="mx-auto max-w-7xl px-4">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
          <div>
            <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-gray-900">Colección</h2>
            <p class="text-gray-600 mt-1">Hecho en México 🇲🇽 • Envíos a todo el país</p>
          </div>
          <!-- Filtros -->
          <form id="filters" class="grid grid-cols-2 md:flex gap-2">
            <input id="q" type="text" placeholder="Buscar modelo o color…"
                   class="col-span-2 md:col-span-1 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm placeholder:text-gray-400 focus:border-gray-900 focus:ring-0">
            <select id="cat" class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm">
              <option value="">Categoría</option>
              <option value="sandalia">Sandalia</option>
              <option value="tacón">Tacón</option>
              <option value="casual">Casual</option>
              <option value="confort">Confort</option>
            </select>
            <select id="size" class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm">
              <option value="">Talla</option>
              <option>22</option><option>23</option><option>24</option>
              <option>25</option><option>26</option><option>27</option>
            </select>
          </form>
        </div>

        <!-- GRID -->
        <ul id="grid" class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
          <!-- Las cards se inyectan por JS con los datos de abajo -->
        </ul>

        <!-- Paginación demo -->
        <div class="mt-10 flex justify-center">
          <button id="loadMore" class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-900 shadow hover:border-gray-300">
            Cargar más
          </button>
        </div>
      </div>
    </section>

    <!-- LIGHTBOX / QUICK VIEW -->
    <div id="lightbox" class="fixed inset-0 hidden z-50 bg-black/80">
      <button class="absolute top-4 right-4 text-white text-3xl" aria-label="Cerrar" id="lbClose">&times;</button>

      <div class="h-full w-full grid grid-rows-[1fr_auto] place-items-center p-4">
        <img id="lbImg" src="" alt="Vista ampliada" class="max-h-[75vh] max-w-[90vw] rounded-xl shadow-2xl object-contain">
        <div class="mt-3 flex items-center gap-3">
          <button id="prev" class="rounded-lg bg-white/10 px-3 py-2 text-white hover:bg-white/20">← Anterior</button>
          <button id="next" class="rounded-lg bg-white/10 px-3 py-2 text-white hover:bg-white/20">Siguiente →</button>
          <a id="waBtn" target="_blank"
             class="rounded-lg bg-green-500 px-3 py-2 text-white font-semibold hover:bg-green-600">
            Cotizar por WhatsApp
          </a>
        </div>
      </div>
    </div>

    <!-- NOSOTROS -->
    <section id="nosotros" class="bg-gray-50 py-16">
      <div class="mx-auto max-w-3xl px-4 text-center">
        <h2 class="text-2xl font-bold mb-3">Sobre nosotros</h2>
        <p>Fabricamos calzado para dama con materiales de alta calidad, pensado para el día a día y ocasiones especiales.</p>
      </div>
    </section>

    <!-- CONTACTO -->
    <section id="contacto" class="py-16">
      <div class="mx-auto max-w-3xl px-4 text-center">
        <h2 class="text-2xl font-bold mb-4">Contacto</h2>
        <p class="mb-2">Teléfono: <a href="tel:+523331986670" class="text-accent">+52 333 198 6670</a></p>
        <p class="mb-2">Correo: <a href="mailto:info@nuevaera.com" class="text-accent">info@nuevaera.com</a></p>
        <p>Dirección: Calle Ejemplo 123, Ciudad, México</p>
      </div>
    </section>
  </main>

  <footer class="border-t py-6 text-center text-sm text-gray-500">
    &copy; <span id="year"></span> Calzado Nueva Era. Todos los derechos reservados.
  </footer>

  <script src="/js/galeria/fotos.js"></script>
</body>
</html>
