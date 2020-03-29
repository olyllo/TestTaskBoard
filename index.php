<?php
/**
 *
 *
 *
 */
include ('_init.php');

$mySite->start();

//Show authorization/regestration form

    echo $Tasks->getForm();

$mySite->end();

