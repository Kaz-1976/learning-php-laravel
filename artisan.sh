#!/bin/bash
docker compose -f ./compose.production.yml exec app php artisan $@
