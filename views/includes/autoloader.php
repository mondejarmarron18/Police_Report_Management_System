<?php
    spl_autoload_register("autoloader");
    
    function autoloader($classname) {
        $classname = explode('\\', $classname);
        $path = '../controllers/' . $classname[1] . '.php';
        
        return file_exists($path)?require_once($path):0;
    }
?>