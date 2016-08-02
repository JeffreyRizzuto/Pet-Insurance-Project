<?php

class AdminController
{

    public static function run()
    {
        // Perform actions related to a bill
        $action = $_SESSION['action'];
        $arguments = $_SESSION['arguments'];
        switch ($action) {
        	case "adminView":
        		AdminView::showDetails();
        		break;
            case "login":
                self::loginAdmin();
                break;
            case "usersPolicies":
            	self::usersPolicies();
            	break;
            case "deactivatePolicy":
            	self::deactivatePolicy($arguments);
            	break;
            case "getLogs":
            	self::getLogs();
            	break;
            case "activeDeactive":
            	self::getActiveDeactive();
            	break;
            case "overdue":
            	self::getOverdue();
            	break;
            case "deactivateAll":
            	self::deactivateAll($arguments);
            	break;
            case "policyDetails":
            	self::policyDetails($arguments);
            	break;
            default:
        }
    }

    public static function loginAdmin()
    {
        $admin = null;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $admin = new Admin($_POST);
            $admins = AdminDB::getAdminsBy('userName', $admin->getUserName());
            if (empty($admins))
                $admin->setError('userName', 'USER_NAME_DOES_NOT_EXIST');
            elseif ($admin->getPassword() != $admins[0]->getPassword()) {
                $admin->setError('password', 'PASSWORD_DOES_NOT_EXIST');
            } else
                $admin = $admins[0];
        }
        $_SESSION['admin'] = $admin;
        if (is_null($admin) || $admin->getErrorCount() != 0)
            AdminView::showLogin();
        else {
            $_SESSION['authenticatedUser'] = $admin;
            AdminView::showDetails();
        }
    }
    
    public static function usersPolicies(){
    	$policies = null;
    	if ($_SERVER["REQUEST_METHOD"] == "POST") {
    	$policies = AdminDB::getUsersPolicies($_POST['firstName'],$_POST['lastName']);
    	$_SESSION['policies'] = $policies;
    	}
        AdminView::showUsersPolicies();
    }
    
    public static function deactivatePolicy($argument){
    	AdminDB::getDeactivatePolicy($argument);
    	$user = UsersDB::getUsersBy('policyId',$argument);
    	$_POST['firstName'] = $user[0]->getFirstName();
    	$_POST['lastName'] = $user[0]->getLastName();
    	self::usersPolicies();
    }
    
    public static function getLogs(){
    	$logs = null;
    	if ($_SERVER["REQUEST_METHOD"] == "POST") {
    	$logs = AdminDB::getLogs($_POST['type']);
    	}
    	$_SESSION['logs']= $logs;
    	AdminView::showLogs();
    }
    
    public static function getActiveDeactive(){
    	$active = null;
    	if($_SERVER["REQUEST_METHOD"] == "POST"){
    		$active = AdminDB::getActive($_POST['type'],$_POST['active']);
    		$_SESSION['active']=$active;
    		$_SESSION['type']=$_POST['type'];
    	}
    	AdminView::showActiveDeactive();
    }
    
    public static function getOverdue(){
    	$overDue = null;
    	$overDue = AdminDB::getOverDue();
    	$_SESSION['overdue']= $overDue;
    	AdminView::showOverDue();
    }
    
    public static function deactivateAll($arguments){
    	AdminDB::deactivateAll($arguments);
    	$overDue = null;
    	$overDue = AdminDB::getOverDue();
    	$_SESSION['overdue']= $overDue;
    	AdminView::showOverDue();
    }
    
    public static function policyDetails(){
    	$policyDetails = null;
    	$policyDetails = AdminDB::getPolicyDetails();
    	$_SESSION['policyDetails']= $policyDetails;
    	AdminView::showPolicyDetails();
    }
}

?>