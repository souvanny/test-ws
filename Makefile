##################
# Variables
##################

DOCKER_COMPOSE = docker-compose

PHP_FPM=webserver
DOCKER_COMPOSE_PHP_FPM_EXEC = ${DOCKER_COMPOSE} exec -u www-data ${PHP_FPM}

##################
# Docker compose
##################

build:
	${DOCKER_COMPOSE} build

start:
	${DOCKER_COMPOSE} start

stop:
	${DOCKER_COMPOSE} stop

up:
	${DOCKER_COMPOSE} up -d --remove-orphans

down:
	${DOCKER_COMPOSE} down

reset:
	${DOCKER_COMPOSE} --volumes --rmi all

rebuild:
	${DOCKER_COMPOSE} up --build --force-recreate --no-deps

test:
	docker run --rm -v ./www:/app -w /app lamp-webserver php ./phpunit.phar tests/unit/
