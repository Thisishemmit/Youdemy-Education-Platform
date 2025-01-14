<?php
spl_autoload_register(function ($class){
    $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $fullPath = '../' . $classPath . '.php';
    if (file_exists($fullPath)) {
        require_once $fullPath;
        return true;
    } else {
        echo 'Class not found: ' . $class;
        return false;
    }
});
