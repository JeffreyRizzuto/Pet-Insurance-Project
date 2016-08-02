<?php

class UserController
{
    public static function run()
    {
        // Perform actions related to a user address
        $action = $_SESSION['action'];
        $arguments = $_SESSION['arguments'];
        switch ($action) {
            case "new":
                self::newUserAddress();
                break;
            case "show":
            	$users = UsersDB::getUsersBy('userId', $arguments);
            	$user = $users[0];
            	$_SESSION['user'] = $user;
            	UserView::show();
                break;
            case  "showall":
                break;
            case "update":
                self::updateUser();
                break;
            default:
        }
    }
    public static function newUserAddress()
    {
        // Process a new user address
        $userAddress = null;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userAddress = new UserAddress($_POST);
            $userAddress = UserAddressesDB::addUserAddress($userAddress);
        }
        if (is_null($userAddress) || $userAddress->getErrorCount() != 0) {
            $_SESSION['userAddress'] = $userAddress;
            UserAddressView::showNew();
        } else {
            HomeView::show();
            header('Location: /' . $_SESSION['base']);
        }
    }
    public static function updateUser()
    {
        // Process updating review
        $users = UsersDB::getUsersBy('userId', $_SESSION['arguments']);
        if (empty($users)) {
            echo 'error';
            HomeView::show();
        } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
        	$user = $users[0];
        	$_SESSION['user'] = $user;
            $_SESSION['users'] = $users;
            UserView::showUpdate();
        } else {
            $parms = $users[0]->getParameters();
            $parms['email'] = (array_key_exists('email', $_POST)) ? $_POST['email'] : $users[0]->getEmail();
            $parms['phoneNumber'] = (array_key_exists('phoneNumber', $_POST)) ? $_POST['phoneNumber'] : $users[0]->getPhoneNumber();
            $parms['userName'] = (array_key_exists('userName', $_POST)) ? $_POST['userName'] : $users[0]->getUserName();
            $newProfile = new Users($parms);
            $newProfile->setUserId($users[0]->getUserId());
            $user = UsersDB::updateUser($newProfile);
            if ($user->getErrorCount() != 0) {
                $_SESSION['users'] = array($newProfile);
                UserView::showUpdate();
            } else {
                $_SESSION['user'] = $user;
                UserView::show();
            }
        }
    }
}
?>