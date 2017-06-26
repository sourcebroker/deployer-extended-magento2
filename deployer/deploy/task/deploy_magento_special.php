<?php

namespace Deployer;

task('magento:setup:static-content:deploy', function () {
    $staticContentDeployPackages = get('static_content_deploy_packages', []);
    $staticContentDeployPackages = array_merge(get('static_content_deploy_packages_default'),
        $staticContentDeployPackages);

    $staticContentDeployLanguages = get('static_content_deploy_languages', []);
    $staticContentDeployLanguages = array_merge(get('static_content_deploy_languages_default'),
        $staticContentDeployLanguages);

    $staticContentDeployPackagesCmd = implode(' ', array_map(function ($package) {
        return '--theme ' . $package;
    }, $staticContentDeployPackages));

    $staticContentDeployLanguagesCmd = implode(' ', array_map(function ($language) {
        return '--language ' . $language;
    }, $staticContentDeployLanguages));

    run('cd {{release_path}} && {{bin/php}} bin/magento setup:static-content:deploy ' .
        $staticContentDeployLanguagesCmd . ' ' . $staticContentDeployPackagesCmd);
})->desc('Static-content deploy');


task('deploy:magento:clear_static_for_deployed', function () {
    $activeDir = test('[ -L {{deploy_path}}/release ]') ? get('deploy_path') . '/release' : get('deploy_path') . '/current';
    foreach (get('static_content_deploy_packages') as $staticFrontendFolder) {
        run("rm -rf $activeDir/pub/static/frontend/" . $staticFrontendFolder);
    }
})->desc('Flush Magento static frontend cache for regenerated static.');

task('deploy:magento:bugfix_for_deployed_version_txt', function () {
    run('touch {{release_path}}/{{web_path}}static/deployed_version.txt');
})->desc('Create empty deployed_version.txt. Otherwise magento throws error on setup:static-content:deploy.');

task('deploy:magento:checkout_for_overwritten_htaccess', function () {
    run('cd {{deploy_path}}/release/ && git checkout pub/.htaccess');
})->desc('Recreate pub/.htaccess that is overwritten while doing static deploy.');

task('deploy:magento:composer_install_for_update_folder', function () {
    run("cd {{release_path}} && {{bin/composer}} install -d {{release_path}}/update");
})->desc('Installing vendors for magneto update app.');

task('deploy:vendors', function () {
    $composer = get('bin/composer');
    $envVars = get('env_vars') ? 'export ' . get('env_vars') . ' &&' : '';
    run("cd {{release_path}} && $envVars $composer {{composer_options}}");
    // check if this can be separate taskaa
    run("rm -rf {{release_path}}/var/.regenerate");
})->desc('Installing vendors');

task('deploy:maintenance', function () {
    $filenameTmp = tempnam(__DIR__, '_deployer');

    $filename = get('release_path') . '/' . get('web_path') . 'auth/authorized_shared';
    download($filenameTmp, $filename);
    $authorisedIps = explode("\n", file_get_contents($filenameTmp));

    $filename = get('release_path') . '/' . get('web_path') . 'auth/authorized';
    download($filenameTmp, $filename);

    $authorisedIps = array_merge($authorisedIps, explode("\n", file_get_contents($filenameTmp)));
    $authorisedIps = array_filter($authorisedIps);

    run("cd {{release_path}} && {{bin/php}} bin/magento maintenance:allow-ips " . implode(" ", $authorisedIps));
    if (!get('disableMaintainceMode')) {
        run("cd {{release_path}} && {{bin/php}} bin/magento maintenance:enable");
    }
    unlink($filenameTmp);
})->desc('Setting deploy maintenance.');
