ifneq (,$(wildcard ./.env))
	include .env
	export $(shell sed 's/=.*//' .env)
endif

db-import:
	@docker-compose exec php-fpm php database/run.php

start:
	@docker-compose up -d

stop:
	@docker-compose down
