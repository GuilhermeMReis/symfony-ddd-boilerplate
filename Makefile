down:
	docker-compose down

up:
	docker-compose up -d

composer:
	docker-compose exec php composer install

migrate:
	docker-compose exec php symfony console doctrine:cache:clear-metadata
	docker-compose exec php composer migration
	docker-compose exec php composer migrate

clear-cache:
	docker-compose exec php bin/console cache:pool:clear cache.global_clearer

functional-test:
	docker-compose exec php symfony composer test:functional $(test)

fixtures:
	docker-compose exec php composer load:fixtures
