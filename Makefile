.PHONY: up down build bash install test phing cs

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

phing:
	docker-compose exec php ./vendor/bin/phing

cs:
	docker-compose exec php ./vendor/bin/phpcs