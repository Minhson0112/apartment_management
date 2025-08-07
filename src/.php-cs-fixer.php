<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/database',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
        __DIR__ . '/resources/views',
    ])
    ->name('*.php')
    ->exclude('storage')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12'               => true,
        'array_syntax'         => ['syntax' => 'short'],
        'no_unused_imports'    => true,
        'ordered_imports'      => ['sort_algorithm' => 'alpha'],
    ])
    ->setFinder($finder)
;
