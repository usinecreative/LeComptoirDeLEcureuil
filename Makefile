sf=bin/console
assets_dir=./app/Resources/assets
web_dir=web
copy=rsync



all: install

install:
	@composer install -n
	@bundle install --path=vendor/
	@$(sf) doctrine:fixtures:load

deploy:
	@bundle exec cap staging deploy
	@bundle exec cap staging cleanup

assets: assets-compile assets-copy
	@echo "Assets build !"

assets-compile:
	@echo "compiling scss files using compass..."
	@cd $(assets_dir) && compass compile

assets-copy:
	@echo "copying css,js and fonts to web directory..."
	@$(copy) $(assets_dir)/css/* $(web_dir)/css/
	@$(copy) $(assets_dir)/fonts/* $(web_dir)/fonts/
	@$(copy) $(assets_dir)/js/* $(web_dir)/js/
