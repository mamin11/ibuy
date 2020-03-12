<?php

spl_autoload_register('myAutoLoader');

function myAutoLoader ($className){
    $path = 'classes/';
    $extension = '.class.php';
    $file_name = $path .$className .$extension;

    if(!file_exists($file_name)){
        return false;
    }

    include_once $path . $className . $extension;
}

?>