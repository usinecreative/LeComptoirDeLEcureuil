sf=bin/console
assets_dir=./app/Resources/assets
web_dir=web
copy=rsync

all: install

install:
	composer install -n
	make assets
	make cc

update:
	composer update

install-ansible:
	sudo apt-get install python python-pip
	sudo pip install ansible
	ansible-galaxy install carlosbuenosvinos.ansistrano-deploy carlosbuenosvinos.ansistrano-rollback

cc:
	rm -rf var/cache/*
	$(sf) doctrine:cache:clear-metadata

### Deployment ###
production@install:
	ansible-playbook etc/ansible/playbooks/install.yml -i etc/ansible/hosts/hosts

staging@install:
	ansible-playbook etc/ansible/playbooks/install.yml -i etc/ansible/hosts/staging_hosts

production@deploy:
	ansible-playbook etc/ansible/playbooks/deploy.yml -i etc/ansible/hosts/hosts

staging@deploy:
	ansible-playbook etc/ansible/playbooks/deploy.yml -i etc/ansible/hosts/staging_hosts
##################

### Database ###
staging@database.copy-remote-to-local:
	ansible-playbook etc/ansible/playbooks/database/copy-database-to-local.yml -i etc/ansible/hosts/staging_hosts

staging@database.copy-local-to-remote:
	ansible-playbook etc/ansible/playbooks/database/copy-database-to-remote.yml -i etc/ansible/hosts/staging_hosts

production@database.copy-remote-to-local:
	ansible-playbook etc/ansible/playbooks/database/copy-database-to-local.yml -i etc/ansible/hosts/hosts
###############

### Server ###
serve:
	bin/console server:run

synchronize-staging:
	make database_production_copy-to-local
	make database_staging_copy-to-remote
	make images_pull-to-local
	make images_push-to-remote
#############

### Images ###
production@images.copy-remote-to-local:
	ansible-playbook etc/ansible/playbooks/images/images-copy-to-local.yml -i etc/ansible/hosts/hosts

staging@images.copy-local-to-remote:
	ansible-playbook etc/ansible/playbooks/images/images-copy-to-remote.yml -i etc/ansible/hosts/staging_hosts
#############

### Assets ###
assets@build:
	yarn run encore dev
	$(sf) assets:install --symlink

assets@build-production:
	yarn run encore production
	$(sf) assets:install --symlink

assets@watch:
	$(sf) assets:install --symlink
	yarn run encore dev --watch

assets@optimize:
	$(sf) cms:assets:optimize
##############

### Tests ###
tests@phpunit:
	bin/phpunit

tests@database:
	$(sf) doctrine:database:drop --env=test --force --if-exists
	$(sf) doctrine:database:create --env=test
	$(sf) doctrine:schema:create --env=test
	$(sf) hautelook:fixtures:load --env=test -n
#############

run:
	$(sf) server:run

tests-legacy:
	$(sf) doctrine:database:drop --env=test --force --if-exists
	$(sf) doctrine:database:create --env=test
	$(sf) doctrine:schema:create --env=test
	$(sf) hautelook:fixtures:load --env=test -n
	make cc
	$(sf) ca:cl --env=test
	bin/phpunit -c app

php-cs:
	php bin/php-cs-fixer fix src/
