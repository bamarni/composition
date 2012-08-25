<?php

use Composition\Composition;

if (!$loader = @include __DIR__ . '/../vendor/autoload.php') {
    throw new RuntimeException(
        'Please install project dependencies before running the test suite.'
    );
}
$loader->add('Composition\Tests', __DIR__);

Composition::setRootDir(__DIR__ . '/..');