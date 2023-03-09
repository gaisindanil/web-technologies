server-restart:
	docker-compose down -v --remove-orphans
	docker-compose up -d

migrations-diff:
	docker-compose run --rm backend-php-cli php bin/console doctrine:migrations:diff

migrations-migrate:
	docker-compose run --rm backend-php-cli php bin/console doctrine:migrations:migrate

lint:
	docker-compose run --rm backend-php-cli composer lint
	docker-compose run --rm backend-php-cli composer unit-test
	docker-compose run --rm backend-php-cli composer php-cs-fixer fix -- --dry-run --diff
	docker-compose run --rm backend-php-cli composer psalm -- --no-diff

down:
	docker-compose down --remove-orphans

backend-composer-install:
	docker-compose run --rm backend-php-cli composer install

docker-up:
	docker-compose up -d

docker-build:
	docker-compose build --pull

docker-pull:
	docker-compose pull

docker-down-clear:
	docker-compose down -v --remove-orphans

start:
	docker-compose up -d

fixtures-load:
	docker-compose run --rm backend-php-cli php bin/console doctrine:fixtures:load

npm-install:
	docker-compose run --rm backend-node npm install

npm-build:
	docker-compose run --rm backend-node npm run build

composer-update:
	docker-compose run --rm backend-php-cli composer update

assets-install:
    docker-compose run --rm backend-php-cli bin/console assets:install


