<?php

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        '@PSR2' => true,
        'concat_space' => [ 'spacing' => 'one' ],
        'blank_line_after_opening_tag' => true,
        'phpdoc_order' => true,
        'array_syntax' => ['syntax' => 'short'],
        'combine_consecutive_unsets' => true,
        'heredoc_to_nowdoc' => true,
        'no_extra_consecutive_blank_lines' => ['break', 'continue', 'extra', 'return', 'throw', 'use', 'parenthesis_brace_block', 'square_brace_block', 'curly_brace_block'],
        'no_short_echo_tag' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'ordered_class_elements' => true,
        'ordered_imports' => true,
        'phpdoc_add_missing_param_annotation' => true,
        'phpdoc_order' => true,
        'semicolon_after_instruction' => true
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(['src', 'tests/phpunit'])
    )
;
