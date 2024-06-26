<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit387b7b5108c2bcc18d012ad00493df2b
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit387b7b5108c2bcc18d012ad00493df2b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit387b7b5108c2bcc18d012ad00493df2b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit387b7b5108c2bcc18d012ad00493df2b::$classMap;

        }, null, ClassLoader::class);
    }
}
