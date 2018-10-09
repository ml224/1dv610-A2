<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc3ba32f29cc5358ddb66373650040070
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'Dotenv\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Dotenv\\' => 
        array (
            0 => __DIR__ . '/..' . '/vlucas/phpdotenv/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc3ba32f29cc5358ddb66373650040070::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc3ba32f29cc5358ddb66373650040070::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
