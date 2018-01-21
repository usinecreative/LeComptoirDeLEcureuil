sf=bin/console
assets_dir=./app/Resources/assets
web_dir=web
copy=rsync

all: install

install:
	composer install -n
	make assets
	make cc
	make install-ansible

update:
	composer update

install-ansible:
	sudo apt-get install python python-pip
	sudo pip install ansible
	ansible-galaxy install carlosbuenosvinos.ansistrano-deploy carlosbuenosvinos.ansistrano-rollback

install-production:
	ansible-playbook etc/ansible/playbooks/install.yml --ask-become-pass -i etc/ansible/hosts/hosts

install-staging:
	ansible-playbook etc/ansible/playbooks/install.yml --ask-become-pass -i etc/ansible/hosts/staging_hosts

cc:
	rm -rf var/cache/*
	$(sf) doctrine:cache:clear-metadata

deploy-production:
	ansible-playbook etc/ansible/playbooks/deploy.yml -i etc/ansible/hosts/hosts

deploy-staging:
	ansible-playbook etc/ansible/playbooks/deploy.yml -i etc/ansible/hosts/staging_hosts


### Database ###
database_staging_copy-to-local:
	ansible-playbook etc/ansible/playbooks/copy-database-to-local.yml -i etc/ansible/hosts/staging_hosts

database_staging_copy-to-remote:
	ansible-playbook etc/ansible/playbooks/copy-database-to-remote.yml -i etc/ansible/hosts/staging_hosts

database_production_copy-to-local:
	ansible-playbook etc/ansible/playbooks/copy-database-to-local.yml -i etc/ansible/hosts/hosts
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
images_pull-to-local:
	ansible-playbook etc/ansible/playbooks/images-copy-to-local.yml -i etc/ansible/hosts/hosts

images_push-to-remote:
	ansible-playbook etc/ansible/playbooks/images-copy-to-remote.yml -i etc/ansible/hosts/staging_hosts
#############
assets:
	$(sf) jk:assets:build
	$(sf) assets:install --symlink

run:
	$(sf) server:run

tests:
	$(sf) doctrine:schema:drop --env=test --force
	$(sf) doctrine:schema:create --env=test
	$(sf) doctrine:fixtures:load --env=test -n
	make cc
	$(sf) ca:cl --env=test
	bin/phpunit -c app

php-cs:
	php bin/php-cs-fixer fix src/
