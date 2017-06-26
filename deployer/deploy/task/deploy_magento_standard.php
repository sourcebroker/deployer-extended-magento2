<?php

namespace Deployer;

task('magento:setup:upgrade', function () {
    $activeDir = test('[ -L {{deploy_path}}/release ]') ? get('deploy_path') . '/release' : get('deploy_path') . '/current';
    run("cd $activeDir && {{bin/php}} bin/magento setup:upgrade");
})->desc('Run the Magento upgrade process');

task('magento:setup:static-content:deploy', function () {
    $activeDir = test('[ -L {{deploy_path}}/release ]') ? get('deploy_path') . '/release' : get('deploy_path') . '/current';
    run("cd $activeDir && {{bin/php}} bin/magento setup:static-content:deploy");
})->desc('Deploys static view files');

task('magento:maintenance:status', function () {
    $activeDir = test('[ -L {{deploy_path}}/release ]') ? get('deploy_path') . '/release' : get('deploy_path') . '/current';
    run("cd $activeDir && {{bin/php}} bin/magento maintenance:status");
})->desc('Deploys static view files');

task('magento:cache:clean', function () {
    $activeDir = test('[ -L {{deploy_path}}/release ]') ? get('deploy_path') . '/release' : get('deploy_path') . '/current';
    run("cd $activeDir && {{bin/php}} bin/magento cache:clean");
})->desc('Clean Magento cache');

task('magento:cache:flush', function () {
    $activeDir = test('[ -L {{deploy_path}}/release ]') ? get('deploy_path') . '/release' : get('deploy_path') . '/current';
    run("cd $activeDir && {{bin/php}} bin/magento cache:flush");
})->desc('Flush Magento cache storage');