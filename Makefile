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
	bin/console cache:clear

### Deployment ###
install-production:
	ansible-playbook etc/ansible/playbooks/install.yml -i etc/ansible/hosts/hosts

install-staging:
	ansible-playbook etc/ansible/playbooks/install.yml -i etc/ansible/hosts/staging_hosts

deploy-production:
	ansible-playbook etc/ansible/playbooks/deploy.yml -i etc/ansible/hosts/hosts

deploy-staging:
	ansible-playbook etc/ansible/playbooks/deploy.yml -i etc/ansible/hosts/staging_hosts
##################

### Database ###
database_copy-staging-to-local:
	ansible-playbook etc/ansible/playbooks/database/copy-database-to-local.yml -i etc/ansible/hosts/staging_hosts

database_copy-local-to-staging:
	ansible-playbook etc/ansible/playbooks/database/copy-database-to-remote.yml -i etc/ansible/hosts/staging_hosts

database_copy-production-to-local:
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
images_pull-to-local:
	ansible-playbook etc/ansible/playbooks/images/images-copy-to-local.yml -i etc/ansible/hosts/hosts

images_push-to-remote:
	ansible-playbook etc/ansible/playbooks/images/images-copy-to-remote.yml -i etc/ansible/hosts/staging_hosts
#############
assets:
	$(sf) jk:assets:build
	$(sf) assets:install --symlink

run:
	$(sf) server:run

tests:
	$(sf) doctrine:database:drop --env=test --force --if-exists
	$(sf) doctrine:database:create --env=test
	$(sf) doctrine:schema:create --env=test
	$(sf) hautelook:fixtures:load --env=test -n
	make cc
	$(sf) ca:cl --env=test
	bin/phpunit -c app

php-cs:
	php bin/php-cs-fixer fix src/
