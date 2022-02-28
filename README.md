# lumen jobs management
## Dependencies
- docker
- docker-compose
- it exposes ports 3306, 8080, 8081, & it must be not used
- copy .env.example to .env & set smtp mail settings "MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD"
- to test api in postman you can import postman-collections exists in repo 
- there are two users one manager & one regular that system initiated with it in this file [data/users.json](data/users.json), you can use it to login & take **api_token** to make **AUTHORIZATION** in jobs api
## To run system:
docker-compose build  <br />
docker-compose up -d
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