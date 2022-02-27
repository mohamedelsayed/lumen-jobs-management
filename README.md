# lumen jobs management
# list running Docker containers:

sudo docker ps

# to up docker compose:

sudo docker-compose up -d --build

# to down docker compose:

sudo docker-compose down

# to run bash "shell" on container docker:

sudo docker exec -it 3e2e2374e9b1 bash
then run
composer install
php artisan key:generate
chmod o+w ./storage/ -R
php artisan migrate

# to restart docker:

sudo systemctl restart docker.service

# to get status docker:

sudo systemctl status docker.service

# to run laravel:

http://localhost:8080/

# docker compose logs:

sudo docker-compose logs

#to-import-database:
cd db/2022
docker exec -i 10e96e9d1bdd mysql -uroot -proot zielvest < zielvest.sql

# to access phpmyadmin:

http://localhost:8081/

## tests:
### to run tests:
./vendor/phpunit/phpunit/phpunit tests/

## api documentation:
### Auth:
https://documenter.getpostman.com/view/4081658/UVkqquPE

### Jobs
https://documenter.getpostman.com/view/4081658/UVkqquTV