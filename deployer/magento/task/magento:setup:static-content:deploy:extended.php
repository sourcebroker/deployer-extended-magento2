<?php

namespace Deployer;

task('magento:setup:static-content:deploy:extended', function () {
    $areas = ['frontend', 'adminhtml'];
    foreach ($areas as $area) {
        $staticContentDeployThemesCmd = implode(' ', array_map(function ($package) {
            return '--theme ' . $package;
        }, get('static_content_deploy_' . $area . '_themes', [])));

        $staticContentDeployLanguagesCmd = implode(' ', array_map(function ($language) {
            return ' ' . $language;
        }, get('static_content_deploy_' . $area . '_languages', [])));

        run('cd {{release_path}} && {{bin/php}} bin/magento setup:static-content:deploy -a ' . $area . ' '.
            $staticContentDeployLanguagesCmd . ' ' . $staticContentDeployThemesCmd);
    }
})->desc('Static-content deploy for declared themes and languages.');