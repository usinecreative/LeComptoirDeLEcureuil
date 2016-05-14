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
	ansible-playbook etc/ansible/playbooks/deploy.yml --ask-become-pass

cleanup:
	@bundle exec cap staging deploy:cleanup

assets: assets-compile assets-copy
	@echo "Assets build !"

assets-compile:
	@echo "compiling scss files using compass..."
	@cd $(assets_dir) && compass compile

assets-copy:
	@echo "copying css,js and fonts to web directory..."
	@$(copy) $(assets_dir)/css/* $(web_dir)/css/
	@$(copy) $(assets_dir)/fonts/* $(web_dir)/fonts/
	@$(copy) $(assets_dir)/img/* $(web_dir)/img/
	@echo "copying symfony assets"
	@$(sf) assets:install

watch:
	@while [ "true" ] ; do \
		@echo "building symfony assets" ; \
		make assets ; \
		sleep 2; \
	done;
