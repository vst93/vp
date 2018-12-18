<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit28affa675cf2d9972ae97ccf6d885a43
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Medoo\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Medoo\\' => 
        array (
            0 => __DIR__ . '/..' . '/catfan/medoo/src',
        ),
    );

    public static $classMap = array (
        'Text_Template' => __DIR__ . '/..' . '/phpunit/php-text-template/src/Template.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit28affa675cf2d9972ae97ccf6d885a43::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit28affa675cf2d9972ae97ccf6d885a43::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit28affa675cf2d9972ae97ccf6d885a43::$classMap;

        }, null, ClassLoader::class);
    }
}