<?php
class LoginController
{
    public static function run()
    {
    	$user = null;
    	$admin = null;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new Users($_POST);
            $admin = new Admin($_POST);
            $admins = AdminDB::getAdminsBy('userName',$admin->getUserName());
            $users = UsersDB::getUsersBy('userName', $user->getUserName());
            if(!empty($admins)){
            	if($admin->getPassword() != $admins[0]->getPassword()) {
            		$admin->setError('password', 'PASSWORD_DOES_NOT_EXIST');
            	}else
            		$admin = $admins[0];
            }
            	
            elseif (empty($users))
                $user->setError('password', 'USER_NAME_DOES_NOT_EXIST');
            elseif ($user->getPassword() != $users[0]->getPassword()) {
                $user->setError('password', 'PASSWORD_DOES_NOT_EXIST');
            } else
                $user = $users[0];
        }
        $_SESSION['user'] = $user;
        if (is_null($user) && is_null($admin) || $user->getErrorCount() != 0 || $admin->getErrorCount()!=0)
            LoginView::show();
        else {
        	if(!empty($admins)){
        		$_SESSION['admin']=$admin;
        		$_SESSION['authenticatedUser']=$admin;
        		AdminView::show();
        		header('Location: /'.$_SESSION['base'].'/admin/adminView/');
        	}
        	else
        		$_SESSION['authenticatedUser']=$user;
            	HomeView::show();
        }
    }
}

?>