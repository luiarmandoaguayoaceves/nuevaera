@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 pb-12">
    {{-- Header del Panel --}}
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <div class="bg-rose-600 p-2 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </div>
                    <h1 class="text-xl font-bold text-slate-800 tracking-tight">Admin <span class="text-rose-600">Shoes</span></h1>
                </div>

                <div class="flex items-center gap-4">
                    <a href="/" class="text-sm font-medium text-slate-600 hover:text-rose-600 transition-colors">Ver Tienda</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 bg-slate-800 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        {{-- Alertas con diseño mejorado --}}
        @if (session('ok'))
            <div class="mb-6 flex items-center p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-xl shadow-sm">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="font-medium">{{ session('ok') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 flex items-center p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-r-xl shadow-sm">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Columna Izquierda: Formulario de Registro --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 sticky top-24">
                    <div class="p-6 border-b border-slate-100">
                        <h2 class="text-lg font-bold text-slate-800">Nuevo Calzado</h2>
                        <p class="text-xs text-slate-500">Añade productos con imágenes de alta calidad.</p>
                    </div>

                    <form action="{{ route('admin.galeria.producto.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
                        @csrf
                        
                        <input type="hidden" name="activo" value="1">
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" required class="w-full rounded-xl border-slate-200 focus:ring-rose-500 focus:border-rose-500 transition-all text-sm @error('nombre') border-red-500 @enderror" placeholder="Nombre del zapato">
                            @error('nombre') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Modelo/SKU</label>
                                <input type="text" name="modelo" value="{{ old('modelo', $siguienteModelo) }}" class="w-full rounded-xl border-slate-200 bg-slate-50 text-sm font-mono @error('modelo') border-red-500 @enderror">
                                @error('modelo') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Precio</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-slate-400 text-sm">$</span>
                                    <input type="number" name="precio" value="{{ old('precio') }}" step="0.01" class="w-full pl-7 rounded-xl border-slate-200 text-sm @error('precio') border-red-500 @enderror" placeholder="0.00">
                                </div>
                                @error('precio') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Categoría</label>
                            <select name="category_id" class="w-full rounded-xl border-slate-200 text-sm @error('category_id') border-red-500 @enderror">
                                @foreach($categorias as $c)
                                    <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tallas (Separadas por coma)</label>
                            <input type="text" name="tallas" value="{{ old('tallas') }}" class="w-full rounded-xl border-slate-200 text-sm @error('tallas') border-red-500 @enderror" placeholder="Ej: 22,23,24">
                            @error('tallas') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Imágenes</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl hover:border-rose-400 transition-colors cursor-pointer group relative">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-10 w-10 text-slate-400 group-hover:text-rose-500" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                    <p id="file-text" class="text-xs text-slate-600 font-medium">Click para subir</p>
                                    <input type="file" name="files[]" multiple accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="document.getElementById('file-text').innerText = this.files.length > 0 ? this.files.length + ' imagen(es) seleccionada(s)' : 'Click para subir'">
                                </div>
                            </div>
                            @error('files') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                            @error('files.*') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-rose-200 transition-all flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Guardar Producto
                        </button>
                    </form>
                </div>
            </div>

            {{-- Columna Derecha: Listado de Productos --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-xl font-bold text-slate-800">Inventario Actual</h2>
                    <span class="bg-slate-200 text-slate-700 px-3 py-1 rounded-full text-xs font-bold">{{ $productos->total() }} items</span>
                </div>

                @foreach ($productos as $p)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden group">
                    <div class="p-5 flex flex-col md:flex-row gap-6">
                        {{-- Imagen Principal --}}
                        <div class="w-full md:w-32 h-32 rounded-xl bg-slate-100 overflow-hidden relative">
                            @php $img = $p->images->firstWhere('is_primary', true) ?? $p->images->sortBy('orden')->first(); @endphp
                            @if($img)
                                <img src="{{ $img->url }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                            @endif
                        </div>

                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="text-xs font-bold text-rose-500 uppercase tracking-widest">{{ $p->category?->nombre ?? 'Sin categoría' }}</span>
                                    <h3 class="text-lg font-bold text-slate-800">{{ $p->nombre }}</h3>
                                    <p class="text-sm text-slate-500 font-mono">Mod: {{ $p->modelo }} | ${{ number_format((float)($p->precio ?? 0), 2) }}</p>
                                </div>
                                <div class="flex gap-2">
                                    <button class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                                    <form action="{{ route('admin.galeria.producto.destroy', $p) }}" method="POST" onsubmit="return confirm('¿Seguro?')">
                                        @csrf @method('DELETE')
                                        <button class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                    </form>
                                </div>
                            </div>
                            
                            {{-- Mini Galería --}}
                            <div class="mt-4 flex gap-2 overflow-x-auto pb-2">
                                @foreach($p->images->sortBy('orden') as $img)
                                    <div class="w-12 h-12 rounded-lg border border-slate-200 overflow-hidden flex-shrink-0">
                                        <img src="{{ $img->url }}" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="py-4">
                    {{ $productos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection