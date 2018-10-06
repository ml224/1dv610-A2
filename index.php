<?php

require_once('controllers/AppController.php');
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$app = new AppController();
$app->echoPage();




