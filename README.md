# Composition

[![Build Status](https://secure.travis-ci.org/composition/composition.png)](https://secure.travis-ci.org/composition/composition)

Composition provides a lightweight and generic API, that you can use to check your
environment at runtime, instead of manually go checking for regex in constants,
classes/functions existence, matching a version against a class constant, ...

This is a wip, currently it can only check for packages (when using composer as
package managment tool) and php/php-extensions.

## Some examples

You usually need to skip some tests if a package isn't present or if it doesn't
match a given version :
``` php
// if (!class_exists('Vendor\SuperPackage\Core') || version_compare(Vendor\SuperPackage\Core::VERSION, '2.0', '<') {
if (!Composition::has('vendor/super-package', '>=2.0') {
    $this->markTestSkipped('The following tests require "SuperPackage" to be at least at 2.0');
}
```

You want to check your PHP environment :
``` php
Composition::has('ext-mongo');
Composition::has('ext-memcache');
Composition::has('php', '5.4.*');
```