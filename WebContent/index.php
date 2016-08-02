<?php
ob_start();
include("includer.php");
session_start();
$url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
list($fill, $base, $control, $action, $arguments) =
    explode('/', $url, 5) + array("", "", "", "", null);
$_SESSION['base'] = $base;
$_SESSION['control'] = $control;
$_SESSION['action'] = $action;
$_SESSION['arguments'] = $arguments;
	 if (!isset($_SESSION['authenticated']))
	 	$_SESSION['authenticated'] = false;
switch ($control) {
    case "login":
        LoginController::run();
        break;
    case "logout":
        LogoutController::run();
        break;
    case "signup":
        SignupController::run();
        break;
    case "dashboard":
        DashboardController::run();
        break;
    case "user":
        UserController::run();
        break;
    case"bill":
        BillController::run();
        break;
    case"pet":
        PetController::run();
        break;
    case"address":
        UserAddressController::run();
        break;
    case"policy":
        PolicyController::run();
        break;
    case"admin":
        AdminController::run();
        break;
    default:
        HomeView::show();
};
ob_end_flush();
?>	
