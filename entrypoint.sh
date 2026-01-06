#!/bin/sh
set -e

echo "=== ENTRYPOINT VERSION: fix-collision-2 ==="
cd /var/www/html

# hapus cache laravel yang sering nyangkut provider
rm -f bootstrap/cache/*.php || true

# amanin permission
chown -R www-data:www-data storage bootstrap/cache || true
chmod -R 775 storage bootstrap/cache || true

exec apache2-foreground
