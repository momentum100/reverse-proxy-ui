#!/bin/bash
mkdir db
mkdir certs
chown -R 33:33 ./db
chown -R 33:33 ./certs
chown -R 33:33 ./src
chown -R 33:33 ./nginx-configs
IP=$(curl https://ipinfo.io/ip)
PASS=$(tr -dc A-Za-z0-9 </dev/urandom | head -c 12 ; echo '')
/bin/cp -rf ./src/conf.php.template ./src/www/conf.php
sed -i "s/_PASSWORD_/$PASS/g" ./src/www/conf.php
docker compose up -d --build
echo "You can login to:"
echo "http://$IP"
echo "with password:"
echo "$PASS"
