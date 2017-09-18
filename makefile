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

fetch-images:
	ansible-playbook etc/ansible/playbooks/fetch-images.yml -i etc/ansible/hosts/hosts

deploy-staging:
	ansible-playbook etc/ansible/playbooks/deploy.yml -i etc/ansible/hosts/staging_hosts

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
