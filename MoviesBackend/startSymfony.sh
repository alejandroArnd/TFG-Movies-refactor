#!/bin/sh

wait-for-it -h mysql -p 3306 -t 240

composer install

php bin/console doctrine:migrations:migrate --no-interaction

apachectl -D FOREGROUND