#!/bin/sh
set -eu

port="${PORT:-10000}"
case "$port" in
    ''|*[!0-9]*) echo "PORT must be numeric" >&2; exit 1 ;;
esac

sed -ri "s/^Listen [0-9]+$/Listen ${port}/" /etc/apache2/ports.conf
sed -ri "s/<VirtualHost \*:[0-9]+>/<VirtualHost *:${port}>/" /etc/apache2/sites-available/000-default.conf

mkdir -p /var/www/html/writable/cache /var/www/html/writable/logs \
    /var/www/html/writable/session /var/www/html/public/uploads/avatars
chown -R www-data:www-data /var/www/html/writable /var/www/html/public/uploads/avatars

exec apache2-foreground
