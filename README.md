The project is developed on Laravel 10.

DEV Environment:
 - php 8.3
 - mysql
 - redis
 - composer

LOCAL:
For development convenience, Docker is used
 - rename .env.example to .env
 - docker-compose up -d --build
 - docker exec -it project-app-test bash
 - composer install
 - php artisan key:generate
 - php artisan migrate

Running the console command:
 - docker exec -it project-app-test bash
	
 Option 1
 - php artisan app:get-json-car-data https://rus-trip.ru/cars.json
	
 Option 2 (changed the brand name of the last car to Kia!!!)
 - php artisan app:get-json-car-data https://rus-trip.ru/cars2.json

Running tests:
 - docker exec -it project-app-test bash
 - php artisan test
