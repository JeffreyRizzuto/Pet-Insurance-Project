<?php

class PolicyController
{

    public static function run()
    {
        // Perform actions related to a policy
        $action = $_SESSION['action'];
        $arguments = $_SESSION['arguments'];
        switch ($action) {
            case "new":
                self::newPolicy();
                break;
            case "show":
            	$users = UsersDB::getUsersBy('userId',$arguments);
            	$user = $users[0];
            	$_SESSION['user'] = $user;
                $policies = PoliciesDB::getPoliciesBy('policyId', $user->getPolicyId());
                $policies = PoliciesDB::getPoliciesBy('policyNumber', $policies[0]->getPolicyNumber());
                $_SESSION['policies'] = (!empty($policies)) ? $policies : null;
                PoliciesView::show();
                break;
            case  "showall":
                $_SESSION['policies'] = PoliciesDB::getPoliciesBy();
                PolicyView::showall();
                break;
            default:
        }
    }


    public static function newPolicy()
    {
        // Process a new policy
        $policy = null;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $policy = new Policy($_POST);
            $policy = PoliciesDB::addPolicy($policy);
        }
        if (is_null($policy) || $policy->getErrorCount() != 0) {
            $_SESSION['policy'] = $policy;
            PolicyView::showNew();
        } else {
            HomeView::show();
            header('Location: /' . $_SESSION['base']);
        }
    }

}

?>

