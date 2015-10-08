<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->files()
    ->name('*.php')
    ->in(__DIR__ . '/app')
    ->in(__DIR__ . '/tests');

return Symfony\CS\Config\Config::create()
    ->setUsingCache(true)
    ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->fixers([
        '-psr0',
        '-linefeed',
        'short_array_syntax',
        'concat_with_spaces',

    ])
    ->finder($finder);