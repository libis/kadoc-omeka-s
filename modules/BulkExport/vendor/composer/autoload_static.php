<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitea1f441f7690802544b8cfb09dc67247
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PhpOffice\\PhpWord\\' => 18,
        ),
        'O' => 
        array (
            'OpenSpout\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PhpOffice\\PhpWord\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpoffice/phpword/src/PhpWord',
        ),
        'OpenSpout\\' => 
        array (
            0 => __DIR__ . '/..' . '/openspout/openspout/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitea1f441f7690802544b8cfb09dc67247::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitea1f441f7690802544b8cfb09dc67247::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitea1f441f7690802544b8cfb09dc67247::$classMap;

        }, null, ClassLoader::class);
    }
}
