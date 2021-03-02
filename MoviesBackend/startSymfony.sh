#!/bin/sh

wait-for-it -h mysql -p 3306 -t 240

composer install

php bin/console doctrine:migrations:migrate --no-interaction

if [ ! -d "config/jwt" ];
    then mkdir "config/jwt"
    chmod -R 777 config/jwt
    openssl genrsa -aes128 -out config/jwt/private.pem -passout pass:password 3072
    openssl pkey  -in auth/jwt/private.pem -out config/jwt/public.pem -pubout -passin pass:password
    chmod -R 777 config/jwt/*.pem
fi

apachectl -D FOREGROUND