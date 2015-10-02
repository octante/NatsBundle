<?php

$config = Symfony\CS\Config\Config::create()
    // use SYMFONY_LEVEL:
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    // and extra fixers:
    ->fixers([
        'concat_with_spaces',
        'multiline_spaces_before_semicolon',
        'short_array_syntax',
    ]);

if (null === $input->getArgument('path')) {
    $config
        ->finder(
            Symfony\CS\Finder\DefaultFinder::create()
                ->in(__DIR__)
                ->exclude('vendor/')
        );
}

return $config;