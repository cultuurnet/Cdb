.PHONY: up down build bash install test cs

up:
	docker-compose up -d

down:
	docker-compose down

build:
	docker-compose up -d --build

bash:
	docker-compose exec php bash

install:
	docker-compose exec php composer install

test:
	docker-compose exec php ./vendor/bin/phpunit

cs:
	docker-compose exec php ./vendor/bin/phpcs