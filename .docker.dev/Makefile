env ?= .env
include $(env)
export $(shell sed 's/=.*//' $(env))

install:
	docker-compose build --no-cache
	docker-compose up -d

rebuild:
	docker-compose build --no-cache
	docker-compose up -d

start:
	docker-compose up -d

stop:
	docker-compose stop

apache:
	docker-compose exec apache bash

php:
	docker-compose exec php bash

mariadb:
	docker-compose exec mariadb bash

phpmyadmin:
	docker-compose exec phpmyadmin bash

ps:
	docker-compose ps
