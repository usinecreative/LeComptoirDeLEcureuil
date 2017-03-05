<?php

$finder = PhpCsFixer\Finder::create()
    ->in('src')
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'full_opening_tag' => false,
    ])
    ->setFinder($finder)
;
