# Composition [![Build Status](https://secure.travis-ci.org/composition/composition.png)](https://secure.travis-ci.org/composition/composition)

Composition provides a lightweight and generic API, that you can use to check your
environment at runtime, instead of manually go checking for regex in constants,
classes/functions existence, matching a version against a class constant, ...

It only works when using Composer as package management tool.

## Some examples

A single command to check your PHP environment :
``` php
if (!\Composition::has('vendor/super-package', '>=2.0') {
    $this->markTestSkipped('The following tests require "SuperPackage" to be at least at 2.0');
}

\Composition::has('php', '5.4.*');
\Composition::has('ext-mongo');
```

Check the platform :
``` php
if (\Composition::isWindows()) {
// ...
}
```

## Note

This tool should mostly be used in your unit tests, and not be abused in production.