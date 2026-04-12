<header class="bg-slate-900 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="/" class="text-2xl font-bold tracking-tighter">
                    NUEVA<span class="text-rose-500">ERA</span>
                </a>
            </div>
            <nav class="hidden md:flex space-x-8 text-sm font-medium">
                <a href="/" class="hover:text-rose-400 transition-colors">Inicio</a>
                <a href="#" class="hover:text-rose-400 transition-colors">Catálogo</a>
                @auth
                    <a href="{{ route('admin.galeria.index') }}" class="text-rose-500 font-bold">Panel Admin</a>
                @else
                    <a href="{{ route('login') }}" class="hover:text-rose-400 transition-colors">Ingresar</a>
                @endauth
            </nav>
        </div>
    </div>
</header>