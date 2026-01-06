#!/bin/sh
set -e

echo "=== ENTRYPOINT VERSION: 2026-01-06-fix-collision ==="

cd /var/www/html

echo "=== Clearing Laravel caches WITHOUT artisan ==="
echo "Before:"
ls -la bootstrap/cache || true

# Ini yang paling penting: hapus cache provider/config yang bisa nyangkut Collision
rm -f bootstrap/cache/*.php || true

# Bersihkan cache view & cache file
rm -rf storage/framework/views/* || true
rm -rf storage/framework/cache/* || true

echo "After:"
ls -la bootstrap/cache || true

# Permission aman
chown -R www-data:www-data storage bootstrap/cache || true
chmod -R 775 storage bootstrap/cache || true

echo "=== Starting Apache ==="
exec apache2-foreground
