@section('galeria')
    <section x-data="galeria()" class="bg-gradient-to-b from-white to-gray-50">
        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Colección de Calzado</h2>
                    <p class="mt-2 text-gray-600">Diseños para cada ocasión: casual, vestir y confort.</p>
                </div>
                <!-- KPIs pequeños -->
                <div class="flex items-center gap-3 text-sm text-gray-500">
                    <div class="hidden sm:block h-10 w-px bg-gray-200"></div>
                    <span><span x-text="stats.vistos"></span> vistos hoy</span>
                    <span>•</span>
                    <span>Mostrando <b x-text="stats.mostrados"></b> de <b x-text="stats.total"></b></span>
                </div>
            </div>

            <!-- Filtros -->
            <div class="mt-6 grid gap-3 sm:grid-cols-12">
                <div class="sm:col-span-6">
                    <label class="sr-only" for="q">Buscar</label>
                    <div class="relative">
                        <input id="q" x-model="filtros.q" @input="aplicarFiltros" type="text"
                            placeholder="Buscar modelo, color o tipo…"
                            class="w-full rounded-xl border border-gray-200 bg-white/80 px-4 py-2.5 pr-10 shadow-sm placeholder:text-gray-400 focus:border-gray-900 focus:ring-0">
                        <svg class="pointer-events-none absolute right-3 top-2.5 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M12.9 14.32a8 8 0 111.414-1.414l3.387 3.387a1 1 0 01-1.414 1.414l-3.387-3.387zM14 8a6 6 0 11-12 0 6 6 0 0112 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <div class="sm:col-span-3">
                    <select x-model="filtros.categoria" @change="aplicarFiltros"
                        class="w-full rounded-xl border border-gray-200 bg-white/80 px-4 py-2.5 shadow-sm focus:border-gray-900 focus:ring-0">
                        <option value="">Todas las categorías</option>
                        <option value="sandalia">Sandalia</option>
                        <option value="tacón">Tacón</option>
                        <option value="casual">Casual</option>
                        <option value="confort">Confort</option>
                    </select>
                </div>
                <div class="sm:col-span-3">
                    <select x-model="filtros.talla" @change="aplicarFiltros"
                        class="w-full rounded-xl border border-gray-200 bg-white/80 px-4 py-2.5 shadow-sm focus:border-gray-900 focus:ring-0">
                        <option value="">Todas las tallas</option>
                        <template x-for="t in tallas" :key="t">
                            <option :value="t" x-text="'Talla ' + t"></option>
                        </template>
                    </select>
                </div>
            </div>  

            <!-- Grid (dinámico desde BD con imagen_principal) -->
            <ul role="list" class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse($productos as $p)
                    @php
                        $img = $p->imagen_principal ?? asset('img/placeholder.webp');

                        // Si tienes relación category:
                        $categoriaStr = $p->category->slug ?? ($p->category->nombre ?? ($p->categoria ?? ''));
                        $modelo = (string) $p->modelo;
                        $precio = $p->precio ?? null;
                        $badge = $p->badge ?? null;

                        // Tallas viene casteado a array por el modelo
                        $tallas = is_array($p->tallas) ? $p->tallas : [];
                    @endphp

                    <li x-show="mostrar({ modelo: @js($modelo), categoria: @js(Str::lower($categoriaStr)), tallas: @js($tallas) })"
                        x-init="stats.total++;
                        stats.mostrados++"
                        class="group relative overflow-hidden rounded-2xl bg-white ring-1 ring-gray-200/70 shadow-sm transition hover:shadow-lg hover:-translate-y-0.5">
                        <!-- Imagen -->
                        <a href="#" class="block">
                            <div class="relative aspect-[3/4] w-full overflow-hidden bg-gray-100">
                                <div class="absolute inset-0 animate-pulse bg-gray-200"></div>
                                <img src="{{ $img }}" alt="Modelo {{ $modelo }} - Calzado para dama"
                                    loading="lazy" decoding="async"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                    onload="this.previousElementSibling?.remove()" />
                                @if ($badge)
                                    <span
                                        class="absolute left-3 top-3 rounded-full bg-black/80 px-3 py-1 text-xs font-semibold text-white shadow">
                                        {{ $badge }}
                                    </span>
                                @endif

                                <button type="button"
                                    @click.prevent="abrirModal('{{ $img }}','{{ $modelo }}', {{ $precio ?? 0 }})"
                                    class="absolute bottom-3 left-1/2 -translate-x-1/2 rounded-xl bg-white/90 px-3 py-1.5 text-sm font-semibold text-gray-900 shadow opacity-0 backdrop-blur transition group-hover:opacity-100 hover:bg-white">
                                    Vista rápida
                                </button>
                            </div>
                        </a>

                        <!-- Info -->
                        <div class="space-y-1 p-4">
                            <div class="flex items-start justify-between gap-3">
                                <h3 class="text-sm font-semibold text-gray-900">Modelo {{ $modelo }}</h3>
                                @if (!is_null($precio))
                                    <p class="text-sm font-bold text-gray-900">${{ number_format($precio, 2) }} MXN</p>
                                @endif
                            </div>
                            @if ($categoriaStr)
                                <p class="text-xs text-gray-500 capitalize">{{ $categoriaStr }}</p>
                            @endif

                            @if (!empty($tallas))
                                <div class="mt-2 flex flex-wrap gap-1.5">
                                    @foreach ($tallas as $t)
                                        <span
                                            class="rounded-md border border-gray-200 px-2 py-0.5 text-[11px] text-gray-700">T{{ $t }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </li>
                @empty
                    <li class="col-span-full">
                        <div
                            class="rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500">
                            No encontramos productos por ahora.
                        </div>
                    </li>
                @endforelse
            </ul>



            <!-- Paginación / Cargar más -->
            <div class="mt-10 flex items-center justify-center gap-3">
                <button
                    class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-900 shadow-sm hover:border-gray-300"
                    @click="cargarMas">
                    Cargar más
                </button>
                <span class="text-xs text-gray-500 hidden sm:inline">Página <b x-text="pagina"></b></span>
            </div>
        </div>

        <!-- Modal: Vista rápida -->
        <div x-show="modal.abierto" x-transition.opacity class="fixed inset-0 z-50 grid place-items-center bg-black/50 p-4">
            <div @click.away="modal.abierto=false" class="w-full max-w-3xl overflow-hidden rounded-2xl bg-white shadow-2xl">
                <div class="grid gap-0 sm:grid-cols-2">
                    <div class="relative aspect-square bg-gray-100">
                        <img :src="modal.img" :alt="'Modelo ' + modal.modelo" class="h-full w-full object-cover" />
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900">Modelo <span x-text="modal.modelo"></span></h3>
                        <p class="mt-2 text-lg font-semibold text-gray-900">$<span x-text="modal.precio.toFixed(2)"></span>
                            MXN</p>
                        <p class="mt-3 text-sm text-gray-600">Materiales de alta calidad y comodidad para uso diario.</p>
                        <div class="mt-5 flex items-center gap-3">
                            <button
                                class="inline-flex items-center justify-center rounded-xl bg-black px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-900">
                                Solicitar cotización
                            </button>
                            <button @click="modal.abierto=false"
                                class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-900">
                                Cerrar
                            </button>
                        </div>
                        <p class="mt-4 text-xs text-gray-400">Envíos a todo México. Hecho en México 🇲🇽</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    {{-- Alpine.js para la UX sin build --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        function galeria() {
            return {
                filtros: {
                    q: '',
                    categoria: '',
                    talla: ''
                },
                tallas: [22, 23, 24, 25, 26, 27],
                pagina: 1,
                stats: {
                    total: 0,
                    mostrados: 0,
                    vistos: Math.floor(Math.random() * 50) + 20
                },
                modal: {
                    abierto: false,
                    img: '',
                    modelo: '',
                    precio: 0
                },

                aplicarFiltros() {
                    this.stats.mostrados = 0;
                    // x-show evalúa en cada card; aquí solo reiniciamos el contador visual
                    this.$nextTick(() => {
                        // recontar visibles:
                        const visibles = [...document.querySelectorAll('li[x-show]')].filter(el => el
                            .offsetParent !== null).length;
                        this.stats.mostrados = visibles;
                    });
                },
                mostrar(p) {
                    const q = this.filtros.q.trim().toLowerCase();
                    const okQ = !q || (p.modelo.toLowerCase().includes(q));
                    const okCat = !this.filtros.categoria || this.filtros.categoria === p.categoria;
                    const okTalla = !this.filtros.talla || p.tallas.includes(parseInt(this.filtros.talla));
                    return okQ && okCat && okTalla;
                },
                abrirModal(img, modelo, precio) {
                    this.modal = {
                        abierto: true,
                        img,
                        modelo,
                        precio: Number(precio) || 0
                    };
                },
                cargarMas() {
                    // Hook para paginación server-side o fetch. Por ahora, demo:
                    this.pagina++;
                }
            }
        }
    </script>
@endsection
