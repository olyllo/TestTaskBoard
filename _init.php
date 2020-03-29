<?php
/**
 * Включает сайт
 *
 *
 */
session_start();

//connection configuration
include ('config.php');

//Scaning and connection all files base library
$basicLibDir = CMS_FULL_PATH . '/lib/';
$basicLibFiles = scandir($basicLibDir);
foreach ($basicLibFiles as &$file) {
    if (substr_count($file, 'lib.php') == 1 ) {
    	include_once ($basicLibDir . $file);
    }
}
foreach ($basicLibFiles as &$file) {
    if (substr_count($file, 'class.php') == 1 ) {
        include_once ($basicLibDir . $file);
    }
}
foreach ($basicLibFiles as &$file) {
    if (substr_count($file, 'init.php') == 1 ) {
        include_once ($basicLibDir . $file);
    }
}

//Whole site settings
$mySite = new Site();

$mySite->addCSSFile (CMS_BASE_URL . '/css/bootstrap.min.css');
$mySite->addCSSFile (CMS_BASE_URL . '/css/style.css');
$mySite->addCSSFile (CMS_BASE_URL . '/css/style-auth-new.css');

$mySite->addJSFile (CMS_BASE_URL . '/js/jquery-3.1.1.slim.min.js');
$mySite->addJSFile (CMS_BASE_URL . '/js/tether.min.js');
$mySite->addJSFile (CMS_BASE_URL . '/js/popper.min.js');
$mySite->addJSFile (CMS_BASE_URL . '/js/bootstrap.min.js');

$mySite->addCSSFile (CMS_BASE_URL . '/css/style.css');
$mySite->addCSSFile (CMS_BASE_URL . '/css/style-auth-new.css');
$mySite->addJSFile (CMS_BASE_URL . '/js/script.js');
$mySite->addJSFile (CMS_BASE_URL . '/js/loadfile.js');

$Tasks = new Task_Controller();


