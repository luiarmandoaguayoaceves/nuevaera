import './gallery';
import './quick-view';

window.openQuickView = function (product) {
    const modal = document.getElementById('quick-view-modal');
    if (!modal) return;

    // 1. Lógica de Imagen (Forzamos carpeta /img/)
    let imageUrl = '/img/placeholder.webp';
    if (product.images && product.images.length > 0) {
        // Buscamos la principal o tomamos la primera
        const primary = product.images.find(i => i.is_primary == 1) || product.images[0];
        
        // Construimos la URL completa usando la propiedad 'path'
        // Si el path ya trae 'galeria/foto.jpg', esto resultará en /img/galeria/foto.jpg
        imageUrl = window.location.origin + 'storage/' + primary.path;
    }

    // 2. Asignar imagen al contenedor
    const qvImage = document.getElementById('qv-image');
    if (qvImage) {
        qvImage.src = imageUrl;
        qvImage.alt = product.nombre;
    }

    // 3. Llenar campos de texto
    document.getElementById('qv-name').innerText = product.nombre || 'Sin nombre';
    document.getElementById('qv-model').innerText = `MOD: ${product.modelo}`;
    document.getElementById('qv-category').innerText = product.category ? product.category.nombre : 'General';
    document.getElementById('qv-price').innerText = product.precio ? `$${Number(product.precio).toLocaleString()}` : 'Consultar';
    document.getElementById('qv-description').innerText = product.descripcion || 'Sin descripción disponible.';

    // 4. Manejo de Tallas (Seguro contra strings o arrays)
    const sizesContainer = document.getElementById('qv-sizes');
    if (sizesContainer) {
        sizesContainer.innerHTML = '';
        let tallas = [];
        
        if (Array.isArray(product.tallas)) {
            tallas = product.tallas;
        } else if (typeof product.tallas === 'string') {
            tallas = product.tallas.split(',').map(t => t.trim());
        }

        tallas.forEach(t => {
            if (t) {
                sizesContainer.innerHTML += `<span class="px-3 py-2 rounded-lg border border-slate-200 text-xs font-bold bg-slate-50 text-slate-700">${t}</span>`;
            }
        });
    }

    // 5. Botón de WhatsApp dinámico
    const qvWhatsapp = document.getElementById('qv-whatsapp');
    if (qvWhatsapp) {
        const message = encodeURIComponent(`¡Hola! Me interesa el modelo ${product.nombre} (MOD: ${product.modelo}).`);
        qvWhatsapp.href = `https://wa.me/523331986670?text=${message}`;
    }

    // 6. Mostrar modal y bloquear scroll
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
};

// Función para cerrar
window.closeQuickView = function () {
    const modal = document.getElementById('quick-view-modal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
};

// Cerrar con tecla Escape
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        window.closeQuickView();
    }
});