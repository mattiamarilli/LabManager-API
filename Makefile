COMPOSE_PROJECT_NAME=labmanager-api

COMPOSE=docker-compose --project-name=$(COMPOSE_PROJECT_NAME) -f docker/docker-compose.yml
DEVCOMPOSE=$(COMPOSE) -f docker/docker-compose.dev.yml
PRODCOMPOSE=$(COMPOSE)

.PHONY: upd
upd:
	$(PRODCOMPOSE) up -d

.PHONY: up
up:
	$(PRODCOMPOSE) up/Users/andreapaolo/Desktop/Progetti/Progetto Marconi/LabManager-API/Makefile

.PHONY: down
down:
	$(PRODCOMPOSE) down

.PHONY: devup
devup:
	$(DEVCOMPOSE) up

.PHONY: devupd
devupd:
	$(DEVCOMPOSE) up -d

.PHONY: devbuild
devbuild:
	$(DEVCOMPOSE) build

.PHONY: devdown
devdown:
	$(DEVCOMPOSE) down

.PHONY: devclear
devclear:
	$(DEVCOMPOSE) rm

.PHONY: db
db:
	docker exec -it lm-mdb sh -c 'mysql -ulabmanager -plabmanager < /sql/schema.sql'

.PHONY: testdata
testdata: db
	docker exec -it lm-mdb sh -c 'mysql -ulabmanager -plabmanager < /sql/test_data.sql'

.PHONY: proxysetup
proxysetup:
	touch acme.json
	chmod 600 acme.json
	docker network create proxy