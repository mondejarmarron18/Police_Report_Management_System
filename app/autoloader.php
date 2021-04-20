<?php
    spl_autoload_register('autoloader');
    
    function autoloader($classname) {
        $path = dirname(__DIR__) . '/app/models/' . $classname . '.php';

        return file_exists($path)?include_once($path):0;
    }
?>