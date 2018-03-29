<?php

namespace Deployer;

task('magento:deploy:git-checkout', function () {
    $activePath = get('deploy_path') . '/' . (test('[ -L {{deploy_path}}/release ]') ? 'release' : 'current');
    foreach (get('magento_git_checkout_items', []) as $checkoutItem) {
        run('cd ' . $activePath . ' && git checkout ' . escapeshellarg($checkoutItem));
    }
})->desc('Checkout for files/folders on git repo.');
