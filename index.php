<?php

require_once('controller/MainController.php');

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$controller = new MainController();
$controller->renderPage();




