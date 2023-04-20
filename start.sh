#!/bin/bash
mkdir db
mkdir certs
chown -R 33:33 ./db
chown -R 33:33 ./certs
chown -R 33:33 ./src
chown -R 33:33 ./nginx-configs
docker compose up -d --build
