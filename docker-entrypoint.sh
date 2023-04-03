#!/bin/sh
set -e

# log
rm -f /app/storage/logs/app.log
touch /app/storage/logs/app.log
chown -R www-data:www-data /app/storage

exec supervisord -c /etc/supervisord.conf
