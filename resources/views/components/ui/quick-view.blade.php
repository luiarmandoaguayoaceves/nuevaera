{{-- resources/views/components/ui/quick-view.blade.php --}}
<div id="quick-view-modal" class="fixed inset-0 z-[60] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">

    {{-- Overlay (Fondo oscuro) --}}
    <div class="flex min-h-screen items-end justify-center p-0 text-center sm:items-center sm:p-4">
        <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm transition-opacity" onclick="closeQuickView()"></div>

        {{-- Contenedor del Modal --}}
        <div
            class="relative transform overflow-hidden rounded-t-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl sm:rounded-3xl">

            {{-- Busca este botón en tu modal --}}
            <button onclick="closeQuickView()"
                class="absolute right-4 top-4 z-10 rounded-full bg-slate-100 p-2 text-slate-500 hover:bg-rose-100 hover:text-rose-600 transition-colors">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>

            <div class="flex flex-col md:flex-row">
                {{-- Galería de Imágenes (Lado Izquierdo) --}}
                <div class="w-full md:w-1/2 bg-slate-50">
                    <div class="aspect-square relative group">
                        <img id="qv-image" src="" alt="" class="h-full w-full object-cover">
                        {{-- Badge de estado --}}
                        <span id="qv-badge"
                            class="absolute left-4 top-4 rounded-full bg-rose-600 px-3 py-1 text-xs font-bold text-white shadow-lg"></span>
                    </div>
                    {{-- Miniaturas (Opcional si tienes varias imágenes) --}}
                    <div id="qv-thumbnails" class="flex gap-2 p-4 overflow-x-auto">
                        {{-- Se llena con JS --}}
                    </div>
                </div>

                {{-- Información (Lado Derecho) --}}
                <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                    <h2 id="qv-category" class="text-sm font-bold uppercase tracking-widest text-rose-600 mb-2"></h2>
                    <h3 id="qv-name" class="text-3xl font-black text-slate-900 mb-4 leading-tight"></h3>

                    <div class="flex items-center gap-4 mb-6">
                        <span id="qv-price" class="text-2xl font-bold text-slate-900"></span>
                        <span class="text-sm text-slate-400 font-mono" id="qv-model"></span>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h4 class="text-xs font-bold uppercase text-slate-500 mb-3 tracking-wider">Tallas
                                Disponibles</h4>
                            <div id="qv-sizes" class="flex flex-wrap gap-2">
                                {{-- Se llena con JS --}}
                            </div>
                        </div>

                        <div>
                            <h4 class="text-xs font-bold uppercase text-slate-500 mb-3 tracking-wider">Descripción</h4>
                            <p id="qv-description" class="text-slate-600 leading-relaxed text-sm"></p>
                        </div>

                        <div class="pt-6">
                            <a id="qv-whatsapp" href="#" target="_blank"
                                class="flex w-full items-center justify-center gap-3 rounded-2xl bg-green-600 px-8 py-4 text-sm font-bold text-white shadow-xl shadow-green-900/20 hover:bg-green-500 transition-all hover:-translate-y-1">
                                <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                                    <path
                                        d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.438 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z" />
                                </svg>
                                Consultar por WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
