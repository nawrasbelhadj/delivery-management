#install docker
docker-dev: docker-dev-up-build docker-dev-clear-cache docker-dev-reload-data docker-dev-restart

docker-dev-up-build:
	docker-compose up -d --build
docker-dev-build:
	docker-compose build

docker-dev-clean:
	docker-compose down

docker-dev-reload:
	docker-compose up -d

docker-dev-restart: docker-dev-stop docker-dev-start

docker-dev-stop:
	docker-compose stop

docker-dev-start:
	docker-compose up -d

#docker-dev-shell:
#	docker-compose exec php bash

docker-dev-clear-cache:
	docker-compose exec php make clear-cache

docker-dev-reload-data:
	docker-compose exec php make reload-data

docker-doctrine-schema-update:
	docker-compose exec php make doctrine-schema-update

docker-dev-clean-cache:
	docker-compose exec php make clean-cache

#fixtures:
#	php bin/console doctrine:fixtures:load

doctrine-schema-update:
	php bin/console doctrine:schema:update --force

clean-cache:
	if [ -d /var/cache ]; then rm -rf var/cache; fi

reload-data: clean-cache doctrine-schema-update

docker-dev-composer-update:
	docker-compose exec php make composer-update

docker-dev-composer-install:
	docker-compose exec php make composer-install

composer-install:
	composer install

composer-update:
	composer update

docker-dev-shell:
	docker exec -it  delivery-management_php_1 bash

docker-dev-phpcs:
	docker exec -it  delivery-management_php_1 make php-cs

docker-dev-phpcbf:
	docker exec -it  delivery-management_php_1 make php-cs

docker-dev-phpcs-fix: docker-dev-phpcs docker-dev-cbf

php-cs:
	vendor/bin/phpcs

php-cbf:
	vendor/bin/phpcbf