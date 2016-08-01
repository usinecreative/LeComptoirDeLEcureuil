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

install-server:
	ansible-playbook etc/ansible/playbooks/install.yml --ask-become-pass

cc:
	rm -rf var/cache/*
	$(sf) doctrine:cache:clear-metadata


deploy:
	ansible-playbook etc/ansible/playbooks/deploy.yml



assets:
	$(sf) jk:assets:build

watch:
	@while [ "true" ] ; do \
		@echo "building symfony assets" ; \
		make assets ; \
		sleep 2; \
	done;


install-admin-symlink:
	rm -rf vendor/lag/adminbundle
	mkdir src/LAG
	ln -s /home/johnkrovitch/Projects/AdminBundle/AdminBundle src/LAG/AdminBundle

install-sam-symlink:
	rm -rf vendor/johnkrovitch/sam
	mkdir src/JK
	ln -s /home/johnkrovitch/Projects/JK/Sam src/JK/Sam

run:
	$(sf) server:run
