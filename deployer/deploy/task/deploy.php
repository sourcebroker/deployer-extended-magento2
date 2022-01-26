<?php

namespace Deployer;

task('deploy', [

    // Standard deployer task.
    'deploy:info',

    // Read more on https://github.com/sourcebroker/deployer-extended#deploy-check-lock
    'deploy:check_lock',

    // Read more on https://github.com/sourcebroker/deployer-extended#deploy-check-composer-install
    'deploy:check_composer_install',

    // Read more on https://github.com/sourcebroker/deployer-extended#deploy-check-branch-local
    'deploy:check_branch_local',

    // Read more on https://github.com/sourcebroker/deployer-extended#deploy-check-branch
    'deploy:check_branch',

    // Standard Deployer "deploy:prepare" command.
    'deploy:prepare',

    // Standard Deployer "deploy:lock" command.
    'deploy:lock',

    // Standard Deployer "deploy:release" command.
    'deploy:release',

    // Standard Deployer "deploy:update_code" command.
    'deploy:update_code',

    // Standard Deployer "deploy:shared" command.
    'deploy:shared',

    // Standard Deployer "deploy:writable" command.
    'deploy:writable',

    // Standard Deployer "deploy:vendors" command.
    'deploy:vendors',

    // Git checkout for files overwritten while composer install for magento/magento2-base
    'magento:deploy:git-checkout',

    // Standard Deployer "deploy:clear_paths" command.
    'deploy:clear_paths',

    // Create database backup, compress and copy to database store.
    // Read more on https://github.com/sourcebroker/deployer-extended-database#db-backup
    'db:backup',

    // Clear php cli cache.
    // Read more on https://github.com/sourcebroker/deployer-extended#cache-clear-php-cli
    'cache:clear_php_cli',

    // Standard Magento "setup:di:compile" command.
    'magento:setup:di:compile',

    // Call "magento setup:static-content:deploy" with parameters for themes and languages
    'magento:setup:static-content:deploy:extended',

    // Start buffering http requests. No frontend access possible from now.
    // Read more on https://github.com/sourcebroker/deployer-extended#buffer-start
    'buffer:start',

    // Standard Magento "setup:db:schema:upgrade" command.
    'magento:setup:db-schema:upgrade',

    // Standard Magento "setup:db:data:upgrade" command.
    'magento:setup:db-data:upgrade',

    // Standard Magento "app:config:import" command.
    'magento:app:config:import',

    // Standard Magento "cache:flush" command.
    'magento:cache:flush',

    // Standard Deployer "deploy:symlink" (symlink release/x/ to current/)
    'deploy:symlink',

    // Clear php cli cache.
    // Read more on https://github.com/sourcebroker/deployer-extended#cache-clear-php-cli
    'cache:clear_php_cli',

    // Clear frontend http cache.
    // Read more on https://github.com/sourcebroker/deployer-extended#cache-clear-php-http
    'cache:clear_php_http',

    // Frontend access possible again from now
    // Read more on https://github.com/sourcebroker/deployer-extended#buffer-stop
    'buffer:stop',

    // Standard deployer task.
    'deploy:unlock',

    // Standard deployer task.
    'cleanup',

    // Read more on https://github.com/sourcebroker/deployer-extended#deploy-extend-log
    'deploy:extend_log',

    // Standard deployer task.
    'success',

])->desc('Deploy your Magento 2.2');
