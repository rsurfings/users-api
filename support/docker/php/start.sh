#!/bin/sh

# supervisor
#exec supervisord -c /etc/supervisord.conf

composer install && composer dump-autoload -o