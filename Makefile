api-up: api-composer-install api-migrations api-fixtures api-tests

api-composer-install:
	docker-compose run --rm php-cli composer install

api-migrations:
	docker-compose run --rm --no-deps php-cli bin/console do:mi:mi --no-interaction

api-fixtures:
	docker-compose run --rm --no-deps php-cli bin/console do:fi:lo --no-interaction

api-tests:
	docker-compose run --rm --no-deps php-cli ./bin/phpunit
