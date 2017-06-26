<?php

namespace Deployer;

task('deploy', [
    // Read more on https://github.com/sourcebroker/deployer-extended#deploy-check-lock
    'deploy:check_lock',

    // Read more on https://github.com/sourcebroker/deployer-extended#deploy-check-composer-install
    'deploy:check_composer_install',

    // Standard deployer deploy:prepare
    'deploy:prepare',

    // Standard deployer deploy:lock
    'deploy:lock',

    // Standard deployer deploy:release
    'deploy:release',

    // Standard deployer deploy:update_code
    'deploy:update_code',

    // Standard deployer deploy:shared
    'deploy:shared',

    // Standard deployer deploy:writable
    'deploy:writable',

    // Standard deployer deploy:vendors
    'deploy:vendors',

    // Call "composer install" in /update folder as its separate project
    'deploy:magento:composer_install_for_update_folder',

    //
    'deploy:magento:checkout_for_overwritten_htaccess',

    // Standard deployer deploy:clear_paths
    'deploy:clear_paths',

    // Clear php cli cache.
    // Read more on https://github.com/sourcebroker/deployer-extended#php-clear-cache-cli
    'php:clear_cache_cli',

    // Start buffering http requests. No frontend access possible from now.
    // Read more on https://github.com/sourcebroker/deployer-extended#buffer-start
    'buffer:start',

    // Call "magento setup:upgrade"
    'magento:setup:upgrade',

    //'deploy:copy_from_previous_release'

    'deploy:magento:clear_static_for_deployed',

    //
    'deploy:magento:bugfix_for_deployed_version_txt',

    //
    'deploy:setup:static-content:deploy',

    // Set the IPs for maintenance mode
    'deploy:maintenance',

    // Standard deployer symlink (symlink release/x/ to current/)
    'deploy:symlink',

    // Clear frontend http cache.
    // Read more on https://github.com/sourcebroker/deployer-extended#php-clear-cache-http
    'php:clear_cache_http',

    // Frontend access possible again from now
    // Read more on https://github.com/sourcebroker/deployer-extended#buffer-stop
    'buffer:stop',

    // Standard deployer deploy:unlock
    'deploy:unlock',

    // Standard deployer cleanup.
    'cleanup',
])->desc('Deploy your Magento2');