<?php

namespace Deployer;

set('disableMaintainceMode', false);
// all packages by default
set('static_content_deploy_packages_default', []);
// default language by default
set('static_content_deploy_languages_default', ['en_US']);


set('web_path', 'pub/');

set('shared_dirs', [
        '{{web_path}}media',
        'var/backups',
        'var/composer_home',
        'var/importexport',
        'var/import_history',
        'var/log',
        'var/session',
        'var/tmp'
    ]
);

set('shared_files', [
    'app/etc/env.php',
    'var/.setup_cronjob_status',
    'var/.update_cronjob_status',
    'pub/auth/authorized_shared',
]);

set('copy_dirs', [
    'pub/static/adminhtml',
    'pub/static/frontend'
]);

set('writable_dirs', [
        'var',
        'pub',
    ]
);

set('clear_paths', [
    '.git',
    '.gitignore',
    '.gitattributes',
    '.htaccess',
    '.htaccess.sample',
    '.travis.yml',
    'CHANGELOG.md',
    'CONTRIBUTING.md',
    'COPYING.txt',
    'Gruntfile.js.sample',
    'index.php',
    'ISSUE_TEMPLATE.md',
    'LICENSE.txt',
    'LICENSE_AFL.txt',
    'nginx.conf.sample',
    'package.json.sample',
    'php.ini.sample',
]);

// Look on https://github.com/sourcebroker/deployer-extended#buffer-start for docs
set('buffer_config', [
        'index.php' => [
            'entrypoint_filename' => 'index.php',
        ],
    ]
);

// Look https://github.com/sourcebroker/deployer-extended-media for docs
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
// TODO: change to closure after fix of deployer bug
set('default_stage', (new \SourceBroker\DeployerExtendedMagento2\Drivers\Magento2Driver)->getInstanceName());

set('db_instance', function () {
    return (new \SourceBroker\DeployerExtendedMagento2\Drivers\Magento2Driver)->getInstanceName();
});

set('db_databases', function () {
    return [
        'database_default' => [
            get('db_defaults'),
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
