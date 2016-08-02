<?php

class UserAddressController
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
                $userAddresses = UsersAddressDB::getAddressesBy('userId', $arguments);
            	$users = UsersDB::getUsersBy('userId', $arguments);
            	$user = $users[0];
            	$_SESSION['user'] = $user;
            	$_SESSION['userAddresses'] = $userAddresses;
                UserAddressView::show();
                break;
            case  "showall":
                $_SESSION['userAddresses'] = UserAddressesDB::getUserAddressesBy();
                UserAddressView::showall();
                break;
            case "update":
                self::updateUserAddress();
                break;
            default:
        }
    }


    public static function newUserAddress()
    {
        // Process a new user address
        $userAddress = null;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userAddress = new UsersAddress($_POST);
            $userAddress = UsersAddressDB::addAddress($userAddress);
        }
        if (is_null($userAddress) || $userAddress->getErrorCount() != 0) {
            $_SESSION['userAddress'] = $userAddress;
            UserAddressView::showNew();
        } else {
            $users = UsersDB::getUsersBy('userId', $userAddress->getUserId());
            $user = $users[0];
            $_SESSION['user'] = $user;
            UserView::show();
        }
    }
    
    public static function show(){
    	UserAddressView::show();
    }

}

?>