set :domain,               "ks3313894.kimsufi.com"
set :deploy_to,            "/home/johnkrovitch/www/le_comptoir"
set :app_path,             "app"
set :user,                 "johnkrovitch"
set :branch,               "master"
ssh_options[:port] =       "22"

role :web,                 domain
role :app,                 domain
role :db,                  domain, :primary => true

logger.level = Logger::IMPORTANT
#logger.level = Logger::MAX_LEVEL
