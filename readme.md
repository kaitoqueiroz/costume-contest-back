## Installation

1. run `docker-compose up -d`;
<<<<<<< HEAD
2. run `docker exec app composer install`;
3. run `docker exec app php artisan key:generate`;
4. run `docker exec app php artisan migrate`;
5. visit `http://localhost:8082/`;
=======
2. run `composer install`;
3. run `php artisan migrate`;
4. run `php artisan storage:link`;
5. visit `http://localhost:9000/`;
>>>>>>> 0fd49b13dc7a3328d9dfc5e93b5fd08d2239800f

In order to run tests:

* create a `homestead_test` database on your machine;
```sql
CREATE DATABASE `homestead_test` /*!40100 COLLATE 'utf8_unicode_ci' */;
GRANT ALL ON homestead_test.* TO 'homestead'@'%' IDENTIFIED BY 'secret';
``` 
* run `vendor/bin/phpunit`;
