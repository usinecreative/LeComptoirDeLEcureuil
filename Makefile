sf=bin/console
assets_dir=./app/Resources/assets
web_dir=web
copy=rsync



all: install

install:
	@composer install -n
	@bundle install --path=vendor/
	@$(sf) doctrine:fixtures:load

cc:
	rm -rf var/cache/*
	$(sf) doctrine:cache:clear-metadata

backup:
	$(sf) dizda:backup:start

remote-backup:
	@bundle exec cap staging symfony:dizda:backup:start

remote-load:
	@bundle exec cap staging symfony:dizda:backup:load

deploy:
	@bundle exec cap staging deploy
	@bundle exec cap staging deploy:cleanup

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
	@$(sf) assets:install --symlink

watch:
	@while [ "true" ] ; do \
		@echo "building symfony assets" ; \
		make assets ; \
		sleep 2; \
	done;
