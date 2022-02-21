#!/bin/bash

OS := $(shell uname)

ifeq ($(OS),Linux)
	UID = $(shell id -u)
else
	UID = 1000
endif

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

build: ## Rebuilds all the containers
	U_ID=${UID} docker build -t database ./infrastructure/docker/database/
	U_ID=${UID} docker build . -t rest-api -f ./infrastructure/docker/php/Dockerfile
	U_ID=${UID} docker-compose -f infrastructure/docker-compose.yml build

run: ## Start the containers
	U_ID=${UID} docker-compose -f infrastructure/docker-compose.yml up -d

stop: ## Stop the containers
	U_ID=${UID} docker-compose -f infrastructure/docker-compose.yml down -v

install:
	U_ID=${UID} docker-compose -f infrastructure/docker-compose.yml exec -T rest-api composer install

fix-permissions:
	chmod -R 775 infrastructure/docker/database/data/

lint:
	U_ID=${UID} docker-compose -f infrastructure/docker-compose.yml exec -T rest-api ./vendor/bin/phplint ./

validate:
	U_ID=${UID} docker-compose -f infrastructure/docker-compose.yml exec -T rest-api composer validate --strict

test: migrations
	U_ID=${UID} docker-compose -f infrastructure/docker-compose.yml exec -T rest-api ./vendor/phpunit/phpunit/phpunit

wait-for-database:
	U_ID=${UID} bash infrastructure/docker/database/wait-for-database.sh

migrations: wait-for-database
	docker exec -i database sh -c 'exec mysql -uroot -p"toor"  --database="database"' --default-character-set=utf8mb4 < ./infrastructure/docker/database/test-data.sql

.PHONY: build