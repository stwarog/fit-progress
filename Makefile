help:
	php bin/console

migrate:
	php bin/console doctrine:migrations:migrate

build:
	docker-compose pull
	docker-compose build --pull
	docker-compose run --rm tests install
	docker-compose run --rm tests version

start: stop build check

stop:
	docker-compose down -v --remove-orphans
	docker network prune -f

check: phpcs

phpcs:
	composer phpcs
phpcs_fix:
	composer phpcs:fix
deptrac:
	composer deptrac

make tests_unit:
	docker-compose run --rm tests unit

dump:
	docker-compose run --rm tests dump-autoload

check: phpcs deptrac tests_unit
