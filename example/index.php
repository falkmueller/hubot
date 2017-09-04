<?php

// Suppress DateTime warnings, if not set already
date_default_timezone_set(@date_default_timezone_get());

//load autoloader
if(file_exists("vendor/autoload.php")){
    require_once 'vendor/autoload.php';
} else {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    require_once '../vendor/autoload.php';
}

//init app
hubert(__dir__.'/config/');
//run and emit app
hubert()->core()->run();
