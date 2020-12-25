#! /bin/bash

cd /var/www/reles && \
docker-compose down && \
git reset --hard && \
git pull && \
docker-compose up -d --build
