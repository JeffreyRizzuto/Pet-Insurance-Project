<?php

class SignupController
{

    public static function run()
    {
        $user = null;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new Users($_POST);
            $users = UsersDB::getUsersBy('userName', $user->getUserName());
            if (!empty($users))
                $user->setError('userName', 'USER_NAME_ALREADY_EXIST');
        }

        $_SESSION['user'] = $user;
        if (is_null($user) || $user->getErrorCount() != 0) {
            SignupView::show();
        } else {  // Initial link
            $user = UsersDB::addUser($user);
            $_SESSION['user'] = $user;
            UserAddressView::showNew();
        }

    }
}

?>