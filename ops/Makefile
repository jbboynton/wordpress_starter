default: run sleep mysql-restore

# Docker
# ------

build:
	docker build -t xzito/$(SITE_NAME):latest -f ./Dockerfile ../app/.

test:
	echo $(SITE_NAME)

# Docker Compose
# --------------

run:
	docker-compose up -d --build

stop:
	docker-compose stop

clean:
	docker-compose stop
	docker-compose rm -v --force

restart:
	docker-compose stop
	docker-compose up -d --build

reset:
	@docker ps -a -q | xargs docker rm -f
	@docker images -q | xargs docker rmi -f

sleep:
	sleep 20

pull_base:
	docker-compose stop
	docker-compose rm -v --force
	docker pull xzito/xzito_wordpress:latest
	docker-compose up -d --build

wp_log:
	docker logs --tail 50 --timestamps vagrant_wordpress_1

db_log:
	docker logs --tail 50 --timestamps vagrant_db_1

https_log:
	docker logs --tail 50 --timestamps vagrant_https_1

wp_bash:
	docker exec -it vagrant_wordpress_1 /bin/bash

db_bash:
	docker exec -it vagrant_db_1 /bin/bash

https_bash:
	docker exec -it vagrant_https_1 /bin/bash

# MySQL
# -----

#the username, pw, db, and sql filename should come from variables
mysql-restore:
	docker run -i -v /dump:/dump \
		--link vagrant_db_1:db \
		--net vagrant_default \
		--rm mariadb:latest \
		sh -c 'exec mysql -hdb -uroot -proot -f wp_esmv < /dump/esmv.sql'

mysql-dump:
	docker exec vagrant_db_1 sh -c 'exec mysqldump wp_esmv -uroot -proot' > \
		/dump/esmv.sql
