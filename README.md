# lumen jobs management

## to up docker compose:
sudo docker-compose up -d --build


## to run bash "shell" on container docker:

sudo docker exec -it 3e2e2374e9b1 bash
then run
composer install
php artisan key:generate
chmod o+w ./storage/ -R
php artisan migrate

## to access api:
http://localhost:8080/
## to access phpmyadmin:
http://localhost:8081/

## tests:
### to run tests:
./vendor/phpunit/phpunit/phpunit tests/

## api documentation:
### Auth:
https://documenter.getpostman.com/view/4081658/UVkqquPE

### Jobs
https://documenter.getpostman.com/view/4081658/UVkqquTV