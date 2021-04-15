down:
	docker-compose down

up:
	docker-compose up -d

composer:
	docker-compose exec php composer install

migrate:
	docker-compose exec php symfony console doctrine:cache:clear-metadata
	docker-compose exec php composer make:migration
	docker-compose exec php composer migrate