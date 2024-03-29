<?php

namespace Deployer;

set('static_content_deploy_frontend_themes', ['Magento/blank']);
set('static_content_deploy_frontend_languages', ['en_US']);
set('static_content_deploy_adminhtml_themes', ['Magento/backend']);
set('static_content_deploy_adminhtml_languages', ['en_US']);
set('web_path', 'pub/');
set('branch_detect_to_deploy', false);
set('allow_anonymous_stats', false);
set('default_timeout', 900);
set('magento_git_checkout_items', ['{{web_path}}.htaccess', '{{web_path}}index.php']);

set('shared_dirs', [
        '{{web_path}}media',
        'var/backups',
        'var/composer_home',
        'var/importexport',
        'var/import',
        'var/import_history',
        'var/log',
        'var/report',
        'var/session',
        'var/tmp'
    ]
);

set('shared_files', [
    'app/etc/env.php',
    'var/.maintenance.ip',
    'var/.setup_cronjob_status',
    'var/.update_cronjob_status',
]);

set('writable_dirs', [
        'var',
        '{{web_path}}media',
        '{{web_path}}static',
    ]
);

// The command "php bin/magento setup:upgrade" will not work without:
// 'composer.json',
// 'composer.lock',
// List of files removed based on assumption that cron is run from CLI
set('clear_paths', [
    '.editorconfig',
    '.git',
    '.gitignore',
    '.gitattributes',
    '.htaccess.sample',
    '.nvmrc',
    '.travis.yml',
    'bs-config.js',
    'CHANGELOG.md',
    'CONTRIBUTING.md',
    'COPYING.txt',
    'dev',
    'grunt-config.json',
    'Gruntfile.js.sample',
    'Gruntfile.js',
    'index.php',
    'ISSUE_TEMPLATE.md',
    'LICENSE.txt',
    'LICENSE_AFL.txt',
    'nginx.conf.sample',
    'package.json',
    'package-lock.json',
    'package.json.sample',
    'php.ini.sample',
    '{{web_path}}cron.php',
    '{{web_path}}.user.ini'
]);

// No need to .htaccess in root when web_path is used
if (get('web_path')) {
    add('clear_paths', ['.htaccess']);
}

// Look on https://github.com/sourcebroker/deployer-extended#buffer-start for docs
set('buffer_config', [
        'index.php' => [
            'entrypoint_filename' => get('web_path') . 'index.php',
        ],
    ]
);

// Look https://github.com/sourcebroker/deployer-extended-media for docs
set('media_allow_push_live', false);
set('media_allow_copy_live', false);
set('media_allow_link_live', false);
set('media_allow_pull_live', false);
set('media',
    [
        'filter' => [
            '+ /{{web_path}}',
            '+ /{{web_path}}media/',
            '+ /{{web_path}}media/**',
            '- *'
        ]
    ]);

// Look https://github.com/sourcebroker/deployer-extended-database for docs
set('default_stage', function () {
    return (new \SourceBroker\DeployerExtendedMagento2\Drivers\Magento2Driver)->getInstanceName();
});

// Look https://github.com/sourcebroker/deployer-extended-database for docs
set('db_allow_push_live', false);
set('db_allow_pull_live', false);
set('db_allow_copy_live', false);
set('db_databases', function () {
    return [
        'database_default' => [
            get('db_default', []),
            [
                'post_sql_in_markers' => '
                  UPDATE core_config_data set value="{{firstDomainWithSchemeAndEndingSlash}}" WHERE path="web/unsecure/base_url";
                  UPDATE core_config_data set value="{{firstDomainWithSchemeAndEndingSlash}}" WHERE path="web/secure/base_url";',
            ],
            function () {
                return (new \SourceBroker\DeployerExtendedMagento2\Drivers\Magento2Driver)->getDatabaseConfig();
            },
        ]
    ];
});

// Look https://github.com/sourcebroker/deployer-extended-database#db-dumpclean for docs
set('db_dumpclean_keep', [
    '*' => 5,
    'live' => 10,
]);

// Look https://github.com/sourcebroker/deployer-bulk-tasks for docs
set('bulk_tasks', [
    'magento' => [
        'prefix' => 'magento',
        'binary' => './bin/magento',
        'command_fallback' => '
                    app:config:import Import data from shared configuration files to appropriate data storage
                    cache:flush Flushes cache storage used by cache type(s)
                    setup:di:compile Generates DI configuration and all missing classes that can be auto-generated
                    setup:db-schema:upgrade Installs and upgrades the DB schema
                    setup:db-data:upgrade Installs and upgrades data in the DB
                ',
    ]
]);
require('./vendor/sourcebroker/deployer-bulk-tasks/src/BulkTasks.php');
