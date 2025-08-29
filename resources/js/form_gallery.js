
(function () {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Añade DnD a todos los grids de productos
    document.querySelectorAll('[id^="grid-"]').forEach(setupGrid);

    function setupGrid(grid) {
        let dragged = null;

        grid.addEventListener('dragstart', (e) => {
            const card = e.target.closest('[data-image-id]');
            if (!card) return;
            dragged = card;
            card.classList.add('ring', 'ring-gray-300');
            e.dataTransfer.effectAllowed = 'move';
        });

        grid.addEventListener('dragover', (e) => {
            e.preventDefault();
            const over = e.target.closest('[data-image-id]');
            if (!dragged || !over || dragged === over) return;

            // Inserta antes o después según la posición del ratón
            const rect = over.getBoundingClientRect();
            const before = (e.clientY - rect.top) < rect.height / 2;
            over.parentNode.insertBefore(dragged, before ? over : over.nextSibling);
        });

        grid.addEventListener('drop', async (e) => {
            e.preventDefault();
            if (dragged) {
                dragged.classList.remove('ring', 'ring-gray-300');
                dragged = null;
                await saveOrder(grid);
            }
        });

        grid.addEventListener('dragend', () => {
            if (dragged) dragged.classList.remove('ring', 'ring-gray-300');
            dragged = null;
        });
    }

    async function saveOrder(grid) {
        const productId = grid.getAttribute('data-product-id');
        const payload = Array.from(grid.querySelectorAll('[data-image-id]')).map((el, idx) => ({
            id: parseInt(el.getAttribute('data-image-id')),
            orden: idx + 1
        }));

        try {
            const res = await fetch(`{{ route('admin.galeria.images.sort') }}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    images: payload,
                    product_id: productId
                })
            });

            if (!res.ok) throw new Error('Error al guardar el orden');
            // (Opcional) feedback visual
            grid.classList.add('outline', 'outline-2', 'outline-green-300');
            setTimeout(() => grid.classList.remove('outline', 'outline-2', 'outline-green-300'), 600);
        } catch (err) {
            alert('No se pudo guardar el orden. Reintenta.');
            console.error(err);
        }
    }
})();