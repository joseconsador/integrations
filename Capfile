# REMOVE THIS LINE
exit

require 'bundler/setup'
require 'zendesk/deployment'

set :application, 'zendesk_microsoft_teams'
set :repository, 'git@github.com:zendesk/microsoft_teams_integration.git'
set :require_tag?, false
set :email_notification, ['deploys@zendesk.com']

# Some notes about writing zendesk_deployment tasks:
# - lib/zendesk/deployment/dsl.rb has a bunch of capistrano overrides. Be aware of this!
# - as of v3, sshkit <https://github.com/capistrano/sshkit> and capistrano 3 <https://github.com/capistrano/capistrano> are used
# - sshkit always runs `in: :parallel` by default.
# - when `execute`-ing without a symbol as the first param, sshkit **ignores** `within`, `umask`, and `SSHKit.config.command_map`
# - dbadmin hosts have additional security in place that stops environment stuff from being present.
#
# So:
# - always `fetch` variables previously `set`
# - don't `in: :parallel`
# - don't `execute` a string
# - if something isn't working, bring out your debugger and see which part of the zendesk_deployment gem you need to inspect
# - don't try to run app stuff on dbadmin and expect it to work
namespace :mintegrations do
  task :symlink_log_and_configs do
    deploy_path = fetch(:deploy_to)
    release_path = fetch(:release_path)

    on release_roles do
      execute(:mkdir, "-p #{release_path}/config")

      within release_path do
        execute(:ln, " -nfs #{deploy_path}/config/.env")
        execute(:rm, " -rf ./log")
        execute(:ln, " -nfs #{deploy_path}/log")
      end
    end
  end

  task :install_dependencies do
    release_path = fetch(:release_path)

    on release_roles do
      execute("cd #{release_path}; /opt/composer/composer.phar install --optimize-autoloader --no-interaction --no-scripts")
      execute("cd #{release_path}; php artisan optimize --no-interaction")
    end

    deploy_hosts = roles(:CHANGETHIS).select {|hostname| hostname =~ /app1\./ }
    on deploy_hosts do
      execute("cd #{release_path}; php artisan migrate --no-interaction --force --database=mysql_migrations")
    end
  end

  task :compile_assets do
    release_path = fetch(:release_path)
    app_hosts = roles(:CHANGETHIS)
    on app_hosts do
      execute("cd #{release_path}; npm install &>/dev/null")
      execute("cd #{release_path}; ./node_modules/.bin/gulp --production")
    end
  end

  task :restart do
    app_hosts = roles(:CHANGETHIS)
    on app_hosts do
      execute("sudo service php7.0-fpm restart")
    end

    worker_hosts = roles(:microsoft_teams_worker)
    on worker_hosts do
      execute("sudo service php-worker restart")
    end
  end
end

after 'deploy:fetch_archive_from_mirror', 'mintegrations:symlink_log_and_configs'
after 'mintegrations:symlink_log_and_configs', 'mintegrations:install_dependencies'
after 'mintegrations:install_dependencies', 'mintegrations:compile_assets'
after 'deploy:restart', 'mintegrations:restart'
