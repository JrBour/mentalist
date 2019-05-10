workspace_container=mentalist_workspace_1

install:
	docker exec $(workspace_container) composer install; reset; npm install; reset  

build: install

dev:
	docker exec $(workspace_container) npm run dev;

start:
	(cd laradock; docker-compose up -d php-fpm nginx postgres adminer)

stop:
	(cd laradock; docker-compose down)

artisan: 
	docker exec $(workspace_container) php artisan $(exec)

test: build
	docker exec $(workspace_container) yarn test --coverage

.PHONY: install build dev start stop artisan test