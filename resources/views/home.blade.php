<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calzado Nueva Era</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-white text-gray-700">
    <header class="bg-white shadow">
        <div class="mx-auto max-w-5xl px-4 py-4 flex items-center justify-between">
            <a href="#inicio" class="flex items-center gap-2">
                <img src="/img/logo.png" alt="Logo" class="w-10 h-10">
                <span class="font-semibold">Nueva Era</span>
            </a>
            <nav class="space-x-4 text-sm">
                <a href="#inicio" class="hover:text-rose-500">Inicio</a>
                <a href="#galeria" class="hover:text-rose-500">Galería</a>
                <a href="#nosotros" class="hover:text-rose-500">Nosotros</a>
                <a href="#contacto" class="hover:text-rose-500">Contacto</a>
            </nav>
        </div>
    </header>

    <main>
        <!-- Hero -->
        <section id="inicio" class="relative h-[60vh] bg-cover bg-center flex items-center justify-center" style="background-image:url('/img/portada.webp')">
            <div class="bg-black/60 absolute inset-0"></div>
            <div class="relative z-10 text-center text-white px-4">
                <h1 class="text-4xl font-extrabold mb-4">Calzado Nueva Era</h1>
                <p class="max-w-xl mx-auto">Calzado para toda ocasión con la mejor calidad y estilo.</p>
            </div>
        </section>

        <!-- Galería -->
        <section id="galeria" class="py-16">
            <h2 class="text-2xl font-bold text-center mb-8">Galería</h2>
            <div class="mx-auto max-w-5xl grid grid-cols-2 md:grid-cols-3 gap-4 px-4">
                <button class="group relative overflow-hidden rounded shadow" data-image="/img/galeria/1.jpeg">
                    <img src="/img/galeria/1.jpeg" alt="Producto 1" class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110">
                </button>
                <button class="group relative overflow-hidden rounded shadow" data-image="/img/galeria/2.jpeg">
                    <img src="/img/galeria/2.jpeg" alt="Producto 2" class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110">
                </button>
                <button class="group relative overflow-hidden rounded shadow" data-image="/img/galeria/3.jpeg">
                    <img src="/img/galeria/3.jpeg" alt="Producto 3" class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110">
                </button>
                <button class="group relative overflow-hidden rounded shadow" data-image="/img/galeria/4.jpeg">
                    <img src="/img/galeria/4.jpeg" alt="Producto 4" class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110">
                </button>
                <button class="group relative overflow-hidden rounded shadow" data-image="/img/galeria/5.jpeg">
                    <img src="/img/galeria/5.jpeg" alt="Producto 5" class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110">
                </button>
                <button class="group relative overflow-hidden rounded shadow" data-image="/img/galeria/6.jpeg">
                    <img src="/img/galeria/6.jpeg" alt="Producto 6" class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110">
                </button>
            </div>
        </section>

        <!-- Lightbox -->
        <div id="lightbox" class="fixed inset-0 hidden bg-black/80 items-center justify-center z-50">
            <button id="lightbox-close" class="absolute top-4 right-4 text-white text-3xl" aria-label="Cerrar" >&times;</button>
            <img id="lightbox-img" src="" alt="Imagen ampliada" class="max-h-full max-w-full rounded shadow-lg">
        </div>

        <!-- Nosotros -->
        <section id="nosotros" class="bg-gray-50 py-16">
            <div class="mx-auto max-w-3xl px-4 text-center">
                <h2 class="text-2xl font-bold mb-4">Sobre nosotros</h2>
                <p>
                    Somos una empresa dedicada a la fabricación y venta de calzado para dama. Nuestro compromiso es ofrecer productos de alta calidad que combinan comodidad y diseño para cada momento de tu vida.
                </p>
            </div>
        </section>

        <!-- Contacto -->
        <section id="contacto" class="py-16">
            <div class="mx-auto max-w-3xl px-4 text-center">
                <h2 class="text-2xl font-bold mb-4">Contacto</h2>
                <p class="mb-2">Teléfono: <a href="tel:+521234567890" class="text-rose-500">+52 123 456 7890</a></p>
                <p class="mb-2">Correo: <a href="mailto:info@nuevaera.com" class="text-rose-500">info@nuevaera.com</a></p>
                <p>Dirección: Calle Ejemplo 123, Ciudad, País</p>
            </div>
        </section>
    </main>

    <footer class="bg-white border-t py-4 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} Calzado Nueva Era. Todos los derechos reservados.
    </footer>

    <script>
        document.querySelectorAll('#galeria button').forEach(btn => {
            btn.addEventListener('click', () => {
                const src = btn.dataset.image;
                document.getElementById('lightbox-img').src = src;
                document.getElementById('lightbox').classList.remove('hidden');
                document.getElementById('lightbox').classList.add('flex');
            });
        });

        const closeLightbox = () => {
            document.getElementById('lightbox').classList.add('hidden');
            document.getElementById('lightbox').classList.remove('flex');
        };

        document.getElementById('lightbox-close').addEventListener('click', closeLightbox);
        document.getElementById('lightbox').addEventListener('click', (e) => {
            if (e.target.id === 'lightbox') {
                closeLightbox();
            }
        });
    </script>
</body>
</html>
