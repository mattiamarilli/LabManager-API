COMPOSE_PROJECT_NAME=labmanager-api

COMPOSE=docker-compose --project-name=$(COMPOSE_PROJECT_NAME) -f docker/docker-compose.yml
DEVCOMPOSE=$(COMPOSE) -f docker/docker-compose.dev.yml
PRODCOMPOSE=$(COMPOSE)

.PHONY: upd
upd: setup
	$(PRODCOMPOSE) up -d

.PHONY: down
down:
	$(PRODCOMPOSE) down

.PHONY: devup
devup:
	$(DEVCOMPOSE) up

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