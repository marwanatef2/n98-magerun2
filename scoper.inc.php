<?php
declare(strict_types=1);

// Currently disabled in box.json.dist -> We have issues with robusta-magerun2 modules

use Isolated\Symfony\Component\Finder\Finder;

$polyfillsBootstrap = Finder::create()
    ->files()
    ->in(__DIR__ . '/vendor/symfony/polyfill-*')
    ->name('bootstrap.php');

return [
    'prefix'    => 'RobustaMagerun2\\Ext',
    'whitelist' => [
        'Composer\\*',
        'Magento\\*',
        'Robusta\\*',
        'Symfony\\Polyfill\\*',
        'Symfony\\Component\\Console\\*',
    ],
    'files-whitelist' => array_map(
        static function ($file) {
            return $file->getPathName();
        },
        iterator_to_array($polyfillsBootstrap)
    ),
];
