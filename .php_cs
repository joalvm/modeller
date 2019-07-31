<?php
/*
 * This document has been generated with
 * https://mlocati.github.io/php-cs-fixer-configurator/?version=2.14#configurator
 * you can change this configuration by importing this file.
 */

use PhpCsFixer\Finder;
use PhpCsFixer\Config;

$finder = Finder::create()
    ->exclude(['bootstrap', 'storage', 'vendor', 'database'])
    ->in(getcwd())
    ->name('*.php')
    ->name('*.phpt')
    ->notName('*.blade.php')
    ->notName('_ide_helper.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$rules = [
    '@PSR2' => true,
    '@Symfony' => true,

    'no_empty_comment' => false,

    'no_extra_consecutive_blank_lines' => [
        'tokens' => [
            'curly_brace_block',
            'parenthesis_brace_block',
            'extra',
            'throw',
            'use',
        ]
    ],

    'new_with_braces' => false,

    'trailing_comma_in_multiline_array' => true,

    'array_syntax' => ['syntax' => 'short'],

    'ternary_to_null_coalescing' => true,

    'ordered_imports' => [
        'imports_order' => [ "const", "class", "function" ],
        'sort_algorithm' => 'length'
    ],
];

return Config::create()
    ->setRules($rules)
    ->setFinder($finder)
    ->setUsingCache(true);
