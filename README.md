# mlnr-php

Get it running:

```
docker-compose up
cd mlnr-server
composer install
php artisan migrate[:refresh]
php artisan db:seed
php -S localhost:8000 -t public_html
```
