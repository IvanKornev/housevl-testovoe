#!/usr/bin/bash

docker exec shop-api php artisan migrate
docker exec shop-api php artisan db:seed --class=DatabaseSeeder
