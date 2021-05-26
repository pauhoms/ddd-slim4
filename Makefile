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
	U_ID=${UID} docker build -t thrivo-api ./infrastructure/docker/database/
	U_ID=${UID} docker-compose -f infrastructure/docker-compose.yml build

run: ## Start the containers
	U_ID=${UID} docker-compose -f infrastructure/docker-compose.yml up -d

stop: ## Stop the containers
	U_ID=${UID} docker-compose -f infrastructure/docker-compose.yml down -v

fix-permissions:
	chmod -R 775 infrastructure/docker/database/data/
lint:
	./vendor/bin/phplint ./

auth-dev:
	php -S localhost:8080 -t apps/public apps/public/authentication.php

test:
	./vendor/phpunit/phpunit/phpunit

.PHONY: build