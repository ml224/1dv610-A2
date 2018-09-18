<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
//require_once('controller/LoginRequest.php');
//require_once('model/User.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS

$loginView = new LoginView();
$dateView = new DateTimeView();
$layoutView = new LayoutView(false);

$layoutView->render($loginView, $dateView);

//testing model
/*$user = new User();
echo $user->loginMessage("");
echo $v->getRequestUserName();
*/




