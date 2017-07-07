<?php
function __autoload($class_name) {
    $aObject = explode("_",$class_name);

    $file = array_pop($aObject);

    require_once 'app/'.implode('/',$aObject).'/'.$file . '.php';
}