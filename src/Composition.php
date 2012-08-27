<?php

use Composer\Config;
use Composer\DependencyResolver\Pool;
use Composer\Json\JsonFile;
use Composer\Package\Version\VersionParser;
use Composer\Package\LinkConstraint\VersionConstraint;
use Composer\Repository\InstalledFilesystemRepository;
use Composer\Repository\PlatformRepository;

class Composition
{
    const OS_WINDOWS = 'windows';
    const OS_UNIX = 'unix';

    private static $pool;
    private static $rootDir;

    /**
     * Search for a given package version.
     *
     * Usage examples : Composition::has('php', '5.3.*') // PHP version
     *                  Composition::has('ext-memcache') // PHP extension
     *                  Composition::has('vendor/package', '>2.1') // Package version
     *
     * @param type $packageName  The package name
     * @param type $prettyString An optional version constraint
     *
     * @return boolean           Wether or not the package has been found.
     */
    public static function has($packageName, $prettyString = '*')
    {
        if (null === self::$pool) {
            if (null === self::$rootDir) {
                self::$rootDir = getcwd();
                if (!file_exists(self::$rootDir.'/composer.json')) {
                    throw new \RuntimeException(
                        'Unable to guess the project root dir, please specify it manually using the Composition::setRootDir method.'
                    );
                }
            }

            $minimumStability = 'dev';
            $config = new Config;
            $file = new JsonFile(self::$rootDir.'/composer.json');
            if ($file->exists()) {
                $projectConfig = $file->read();
                $config->merge($projectConfig);
                if (isset($projectConfig['minimum-stability'])) {
                    $minimumStability = $projectConfig['minimum-stability'];
                }
            }
            $vendorDir = self::$rootDir.'/'.$config->get('vendor-dir');

            $pool = new Pool($minimumStability);
            $pool->addRepository(new PlatformRepository());
            $pool->addRepository(new InstalledFilesystemRepository(
                new JsonFile($vendorDir.'/composer/installed.json')
            ));
            $pool->addRepository(new InstalledFilesystemRepository(
                new JsonFile($vendorDir.'/composer/installed_dev.json')
            ));

            self::$pool = $pool;
        }

        $parser = new VersionParser();
        $constraint = $parser->parseConstraints($prettyString);
        $packages = self::$pool->whatProvides($packageName, $constraint);

        return empty($packages) ? false : true;
    }

    /**
     * Get the platform type.
     *
     * @return string
     */
    public function getPlatform()
    {
        if (defined('PHP_WINDOWS_VERSION_MAJOR')) {
            return self::OS_WINDOWS;
        }

        return self::OS_UNIX;
    }

    /**
     * Allow to manually set the project root dir.
     *
     * @param type $rootDir
     */
    public static function setRootDir($rootDir)
    {
        self::$rootDir = $rootDir;
    }
}