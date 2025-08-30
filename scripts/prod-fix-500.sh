#!/usr/bin/env bash
set -euo pipefail

echo "==> Validando directorio de proyecto"
if [[ ! -f artisan ]]; then
  echo "Este script debe ejecutarse en la raíz del proyecto (donde está artisan)" >&2
  exit 1
fi

echo "==> Versión de PHP"
php -v || true

echo "==> Verificando vista requerida"
if [[ -f resources/views/gallery/index.blade.php ]]; then
  echo "OK: resources/views/gallery/index.blade.php existe"
else
  echo "ERROR: Falta resources/views/gallery/index.blade.php. Verifica tu despliegue." >&2
fi

echo "==> Limpiando cachés de Laravel"
php artisan optimize:clear || true
php artisan view:clear || true
php artisan config:clear || true
php artisan route:clear || true

echo "==> Instalando dependencias Composer (sin dev)"
composer install --no-dev --prefer-dist --optimize-autoloader || true
composer dump-autoload -o || true

echo "==> Reconstruyendo cachés (opcional)"
php artisan config:cache || true
php artisan route:cache || true

echo "==> Permisos (ajusta el usuario/grupo según tu servidor)"
if command -v chown >/dev/null 2>&1; then
  sudo chgrp -R www-data storage bootstrap/cache || true
  sudo chmod -R ug+rwx storage bootstrap/cache || true
fi

echo "==> Listo. Revisa el log si persiste el error: storage/logs/laravel.log"

