<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'phpdoc_no_alias_tag' => false,
        'phpdoc_tag_type' => false,
        'array_syntax' => ['syntax' => 'short'],
        'native_function_invocation' => ['include' => ['@compiler_optimized'], 'scope' => 'namespaced', 'strict' => true],
    ])
    ->setFinder($finder)
    ;
