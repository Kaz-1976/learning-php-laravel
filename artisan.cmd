@rem Podman Compose
@podman compose -f ./compose.local.yml exec app php artisan %*
