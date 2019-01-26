# Laravel API for Costume Contest app

* [VueJs Frontend](https://github.com/kaitoqueiroz/costume-contest-front)

## Technologies:

* [Laravel](https://laravel.com/)
* [Docker](https://www.docker.com/)
* [JWT](https://jwt.io/)

## Installation

### Install with Docker compose
add `.env` file: `cp .env.example .env`

configure emails with mailtrap on the `.env` file in order to be able to receive password recover's email:
[Visit Mailtrap](https://mailtrap.io)

```
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=<USERNAME HERE>
MAIL_PASSWORD=<PASSWORD HERE>
MAIL_ENCRYPTION=null
```

run `docker-compose up --build -d`

run `docker exec app composer install`

run `docker exec app php artisan key:generate`

run `docker exec app php artisan migrate`

Populate the database (optional):

run `docker exec app php artisan db:seed`

visit [http://localhost:9000/](http://localhost:9000/) (or your local IP e.g: [http://192.168.10.10:9000/](http://192.168.10.10:9000/));


### In order to run tests:

* create a `homestead_test` database on your machine;
```sql
CREATE DATABASE `homestead_test` /*!40100 COLLATE 'utf8_unicode_ci' */;
GRANT ALL ON homestead_test.* TO 'homestead'@'%' IDENTIFIED BY 'secret';
``` 
* run `docker exec app vendor/bin/phpunit`
