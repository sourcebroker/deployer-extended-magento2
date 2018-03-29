<?php

namespace Deployer;

task('deploy', [
    // Read more on https://github.com/sourcebroker/deployer-extended#deploy-check-lock
    'deploy:check_lock',

    // Read more on https://github.com/sourcebroker/deployer-extended#deploy-check-composer-install
    'deploy:check_composer_install',

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

    // Standard Deployer "deploy:clear_paths" command.
    'deploy:clear_paths',

    // Clear php cli cache.
    // Read more on https://github.com/sourcebroker/deployer-extended#php-clear-cache-cli
    'php:clear_cache_cli',

    // Git checkout for files overwritten while composer install for magento/magento2-base
    'magento:deploy:git_checkout',

    // Standard Magento "setup:di:compile" command.
    'magento:setup:di:compile',

    // Call "magento setup:static-content:deploy" with parameters for themes and languages
    'magento:setup:static-content:deploy:extended',

    // Start buffering http requests. No frontend access possible from now.
    // Read more on https://github.com/sourcebroker/deployer-extended#buffer-start
    'buffer:start',

    // Standard Magento "setup:db:schema:upgrade" command.
    'magento:setup:db:schema:upgrade',

    // Standard Magento "setup:db:data:upgrade" command.
    'magento:setup:db:data:upgrade',

    // Standard Magento "app:config:import" command.
    'magento:app:config:import',

    // Standard Magento "cache:flush" command.
    'magento:cache:flush',

    // Standard Deployer "deploy:symlink" (symlink release/x/ to current/)
    'deploy:symlink',

    // Clear frontend http cache.
    // Read more on https://github.com/sourcebroker/deployer-extended#php-clear-cache-http
    'php:clear_cache_http',

    // Frontend access possible again from now
    // Read more on https://github.com/sourcebroker/deployer-extended#buffer-stop
    'buffer:stop',

    // Standard Deployer "deploy:unlock" command.
    'deploy:unlock',

    // Standard Deployer "cleanup" command.
    'cleanup',
])->desc('Deploy your Magento 2.2');