.PHONY: up down build bash install test stan cs cs-fix ci

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

stan:
	docker-compose exec php ./vendor/bin/phpstan

cs:
	docker-compose exec php ./vendor/bin/php-cs-fixer fix --dry-run

cs-fix:
	docker-compose exec php ./vendor/bin/php-cs-fixer fix

ci: cs stan test