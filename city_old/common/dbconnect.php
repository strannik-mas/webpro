<?php
ini_set('display_errors',1);error_reporting(E_ALL);
    $dbParams = parse_ini_file('conf.ini');
    $link = mysqli_connect($dbParams['db.host'], $dbParams['db.user'], $dbParams['db.pass'], $dbParams['db.name']) or die(mysqli_connect_error());
    $link->set_charset("utf8");	
