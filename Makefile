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

tests: unit behat
unit:
	docker-compose run --rm tests unit
behat:
	docker-compose run --rm tests behat

dump:
	docker-compose run --rm tests dump-autoload

check: phpcs deptrac unit behat

schema:
	php bin/console doctrine:schema:update --force
reset:
	php bin/console doctrine:database:create
	php bin/console doctrine:schema:update --force

reproduce:
	php bin/console app:plan:create FBW 100,5,6eac986a-debe-4e08-8989-7b4fdd94cbf0 120,3,6eac986a-debe-4e08-8989-7b4fdd94cbf0 --id plan-id
	php bin/console app:training:create training-id 2020-01-01 plan-id --id training-id
	php bin/console app:activity:add training-id 120 3 6eac986a-debe-4e08-8989-7b4fdd94cbf0
	php bin/console app:training:list
