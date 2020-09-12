<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit70898a40ebd6b856a8e15b66305fbca4
{
    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'UMC\\Setup\\Classes\\' => 18,
            'UMC\\General\\Classes\\' => 20,
            'UMC\\Controller\\Classes\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'UMC\\Setup\\Classes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes/setup',
        ),
        'UMC\\General\\Classes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes/general',
        ),
        'UMC\\Controller\\Classes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes/controllers',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit70898a40ebd6b856a8e15b66305fbca4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit70898a40ebd6b856a8e15b66305fbca4::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
