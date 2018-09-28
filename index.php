<?php

require_once('controller/MainController.php');
require_once('model/DataBase.php');
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$controller = new MainController();
$controller->renderPage();




