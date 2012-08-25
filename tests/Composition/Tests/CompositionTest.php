<?php

namespace Composition\Tests\Composition;

use Composition\Composition;

class CompositionTest extends \PHPUnit_Framework_TestCase
{
    public function testHasFromPlatform()
    {
        $this->assertTrue(Composition::has('php', PHP_MAJOR_VERSION.'.*'));
        $this->assertTrue(Composition::has('php', PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION.'.'.PHP_RELEASE_VERSION));
        $this->assertFalse(Composition::has('php', PHP_MAJOR_VERSION.'.'.(PHP_MINOR_VERSION+1).'.*'));
    }

    public function testHasFromRequire()
    {
        $this->assertTrue(Composition::has('composer/composer'));
        $this->assertFalse(Composition::has('composer/not-composer'));
    }

    public function testHasFromRequireDev()
    {
        $this->assertTrue(Composition::has('doctrine/common', '>2.0'));
        $this->assertTrue(Composition::has('doctrine/common', '2.3.*'));
        $this->assertFalse(Composition::has('doctrine/common', '2.2.*'));
    }
}