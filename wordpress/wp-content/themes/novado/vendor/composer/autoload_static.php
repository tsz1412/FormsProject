<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf3a4af8370045ad69594719b252e3895
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Tsz\\Novado\\Plugins\\Jetpack\\' => 27,
            'Tsz\\Novado\\Plugins\\ACF\\' => 23,
            'Tsz\\Novado\\CPT\\' => 15,
            'Tsz\\Novado\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Tsz\\Novado\\Plugins\\Jetpack\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc/plugins/jetpack',
        ),
        'Tsz\\Novado\\Plugins\\ACF\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc/plugins/acf',
        ),
        'Tsz\\Novado\\CPT\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc/custom-types',
        ),
        'Tsz\\Novado\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf3a4af8370045ad69594719b252e3895::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf3a4af8370045ad69594719b252e3895::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf3a4af8370045ad69594719b252e3895::$classMap;

        }, null, ClassLoader::class);
    }
}
