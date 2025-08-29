
document.addEventListener('DOMContentLoaded', () => {
    const token = getCsrfToken();
    if (!token) {
        console.error('CSRF token no encontrado. Asegúrate de tener <meta name="csrf-token" content="{{ csrf_token() }}"> en el <head>.');
        return; // evita seguir sin token
    }

    // Añade DnD a todos los grids de productos
    document.querySelectorAll('[id^="grid-"]').forEach(setupGrid);

    function setupGrid(grid) {
        let dragged = null;

        grid.addEventListener('dragstart', (e) => {
            const card = e.target.closest('[data-image-id]');
            if (!card) return;
            dragged = card;
            card.classList.add('ring', 'ring-gray-300');
            // algunos navegadores requieren setData para drag
            if (e.dataTransfer) e.dataTransfer.setData('text/plain', '');
            e.dataTransfer && (e.dataTransfer.effectAllowed = 'move');
        });

        grid.addEventListener('dragover', (e) => {
            e.preventDefault();
            const over = e.target.closest('[data-image-id]');
            if (!dragged || !over || dragged === over) return;

            const rect = over.getBoundingClientRect();
            const before = (e.clientY - rect.top) < rect.height / 2;
            over.parentNode.insertBefore(dragged, before ? over : over.nextSibling);
        });

        grid.addEventListener('drop', async (e) => {
            e.preventDefault();
            if (dragged) {
                dragged.classList.remove('ring', 'ring-gray-300');
                await saveOrder(grid, token);
                dragged = null;
            }
        });

        grid.addEventListener('dragend', () => {
            if (dragged) dragged.classList.remove('ring', 'ring-gray-300');
            dragged = null;
        });
    }

    async function saveOrder(grid, token) {
        const productId = grid.getAttribute('data-product-id');
        const payload = Array.from(grid.querySelectorAll('[data-image-id]')).map((el, idx) => ({
            id: Number(el.getAttribute('data-image-id')),
            orden: idx + 1
        }));

        try {
            const res = await fetch('/admin/galeria/images/sort', { // usa ruta relativa para evitar CORS
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin', // envía cookies (sesión/CSRF)
                body: JSON.stringify({
                    images: payload,
                    product_id: productId
                })
            });

            if (!res.ok) {
                const txt = await res.text().catch(() => '');
                throw new Error(`Error al guardar el orden: ${res.status} ${txt}`);
            }

            // feedback visual
            grid.classList.add('outline', 'outline-2', 'outline-green-300');
            setTimeout(() => grid.classList.remove('outline', 'outline-2', 'outline-green-300'), 600);
        } catch (err) {
            console.error(err);
            alert('No se pudo guardar el orden. Reintenta.');
        }
    }

    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        if (meta && meta.content) return meta.content;

        const input = document.querySelector('input[name="_token"]');
        if (input && input.value) return input.value;

        // Fallback para Laravel Sanctum: cookie XSRF-TOKEN
        const m = document.cookie.match(/XSRF-TOKEN=([^;]+)/);
        if (m) return decodeURIComponent(m[1]);

        return '';
    }
});
