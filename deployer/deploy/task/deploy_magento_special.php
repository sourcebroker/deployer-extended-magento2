<?php

namespace Deployer;

task('magento:deploy:git_checkout', function () {
    $activePath = get('deploy_path') . '/' . (test('[ -L {{deploy_path}}/release ]') ? 'release' : 'current');
    foreach (get('magento_git_checkout_items', []) as $checkoutItem) {
        run('cd ' . $activePath . ' && git checkout ' . escapeshellarg($checkoutItem));
    }
})->desc('Checkout for files/folders on git repo.');


task('magento:setup:static-content:deploy:extended', function () {
    $areas = ['frontend', 'adminhtml'];
    foreach ($areas as $area) {
        $staticContentDeployThemesCmd = implode(' ', array_map(function ($package) {
            return '--theme ' . $package;
        }, get('static_content_deploy_' . $area . '_themes', [])));

        $staticContentDeployLanguagesCmd = implode(' ', array_map(function ($language) {
            return '--language ' . $language;
        }, get('static_content_deploy_' . $area . '_languages', [])));

        run('cd {{release_path}} && {{bin/php}} bin/magento setup:static-content:deploy ' .
            $staticContentDeployLanguagesCmd . ' ' . $staticContentDeployThemesCmd);
    }
})->desc('Static-content deploy for declared themes and languages.');
