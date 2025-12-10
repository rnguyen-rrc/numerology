<?php
spl_autoload_register(function ($class) {

    $root = __DIR__ . '/';

    $paths = [
        $root . 'classes/' . $class . '.php',
        $root . 'core/' . $class . '.php',
        $root . 'numerology/' . $class . '.php',
        $root . 'numerology/calculator/' . $class . '.php', // ✅ ADD THIS
    ];

    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
