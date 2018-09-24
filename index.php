<?php

//INCLUDE THE FILES NEEDED...
require_once('controller/LoginController.php');
require_once('model/DataBase.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$loginController = new LoginController();
$loginController->renderPage();
//$loginController->renderLoginPage();



//CREATE OBJECTS OF THE VIEWS
/*$LoginView = new LoginView()
$LoginRequest = new LoginRequest()
->render($loginView, $dateView);
*/

//testing model
/*echo $user->loginMessage("");
echo $v->getRequestUserName();
*/




