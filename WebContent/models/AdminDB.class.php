<?php

class AdminDB
{

    public static function addAdmin($admin)
    {
        // Inserts $review into the Reviews table and returns reviewId
        $query = "INSERT INTO Admins (userName, password)
		                      VALUES(:userName, :password)";
        try {
            $db = Database::getDB();
            if (is_null($admin) || $admin->getErrorCount() > 0)
                return $admin;

            $statement = $db->prepare($query);
            $statement->bindValue(":userName", $admin->getUserName());
            $statement->bindValue(":password", $admin->getPassword());
            $statement->execute();
            $statement->closeCursor();
            $admin->setAdminId($db->lastInsertId("adminId"));
        } catch (Exception $e) { // Not permanent error handling
            $admin->setError('adminId', 'LIST_INVALID');
        }
        return $admin;
    }

    public static function getAdminsBy($type = null, $value = null)
    {
        // Returns User objects whose $type field has value $value
        $adminRows = AdminDB::getAdminsRowSetsBy($type, $value);
        return AdminDB::getAdminsArray($adminRows);
    }

    public static function getAdminsRowSetsBy($type = null, $value = null)
    {
        // Returns the rows of Users whose $type field has value $value
        $allowedTypes = ["adminId", "userName"];
        $adminsRowSets = array();
        try {
            $db = Database::getDB();
            $query = "SELECT adminId, password, userName FROM Admins";
            if (!is_null($type)) {
                if (!in_array($type, $allowedTypes))
                    throw new PDOException("$type not an allowed search criterion for Admins");
                $query = $query . " WHERE ($type = :$type)";
                $statement = $db->prepare($query);
                $statement->bindParam(":$type", $value);
            } else
                $statement = $db->prepare($query);
            $statement->execute();
            $adminsRowSets = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement->closeCursor();
        } catch (Exception $e) { // Not permanent error handling
            echo "<p>Error getting user rows by $type: " . $e->getMessage() . "</p>";
        }
        return $adminsRowSets;
    }

    public static function getAdminsArray($rowSets)
    {
        // Returns an array of User objects extracted from $rowSets
        $admins = array();
        if (!empty($rowSets)) {
            foreach ($rowSets as $adminRow) {
                $admin = new Admin($adminRow);
                $admin->setAdminId($adminRow['adminId']);
                array_push($admins, $admin);
            }
        }
        return $admins;
    }

    public static function getAdminValuesBy($column, $type = null, $value = null)
    {
        // Returns the $column of Users whose $type field has value $value
        $adminRows = AdminDB::getAdminRowSetsBy($type, $value);
        return AdminDB::getAdminValues($adminRows, $column);
    }

    public static function getAdminValues($rowSets, $column)
    {
        // Returns an array of values from $column extracted from $rowSets
        $adminValues = array();
        foreach ($rowSets as $adminRow) {
            $adminValue = $adminRow[$column];
            array_push($adminValues, $adminValue);
        }
        return $adminValues;
    }
    
    public static function getUsersPolicies($firstName, $lastName){
    	$policiesRowSets = array();
    	$db = Database::getDB ();
    	try {
    		$query = 'SELECT  * from policies WHERE policyNumber IN (SELECT policyNumber FROM users, policies WHERE
			policies.policyId = users.policyId and firstName = "'.$firstName.'" and lastName = "'.$lastName.'" )';
    	
    		$statement = $db->prepare ($query);
    		$statement->execute ();
    		$policiesRowSets = $statement->fetchAll(PDO::FETCH_ASSOC);
    		
    		$statement->closeCursor();
    	} catch (Exception $e) {
    		echo 'wont work';
    	}
    	return $policiesRowSets;
    }
	public static function getDeactivatePolicy($policyId){
		$db = Database::getDB ();
		try {
			$query = "UPDATE policies SET active =0 WHERE policyId = :policyId";
			 
			$statement = $db->prepare ($query);
			$statement->bindValue(":policyId", $policyId);
			$statement->execute ();
			$statement->closeCursor();
		} catch (Exception $e) {
			echo 'wont work';
		}
	}
	
	public static function getLogs($type){
		$logs = array();
		$db = Database::getDB ();
		try {
			$query = 'SELECT  * from ChangeStatusOf'.$type;
			 
			$statement = $db->prepare ($query);
			$statement->execute ();
			$logs = $statement->fetchAll(PDO::FETCH_ASSOC);
	
			$statement->closeCursor();
		} catch (Exception $e) {
			echo 'wont work';
		}
		return $logs;
	}
	
	public static function getActive($type, $active){
		$activeDeactive = array();
		$db = Database::getDB();
		try{
			$query = 'SELECT * from '.$type. ' WHERE active =' . $active;
			$statement = $db->prepare ($query);
			$statement->execute ();
			$activeDeactive = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			$statement->closeCursor();
				} catch (Exception $e) {
			echo 'wont work';
		}
		return $activeDeactive;
	}
	
	public static function getOverDue(){
		$overDue= array();
		$db = Database::getDB();
			try{
			$query = 'SELECT * from overDueBills';
			$statement = $db->prepare ($query);
			$statement->execute ();
			$overDue = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			$statement->closeCursor();
				} catch (Exception $e) {
			echo 'wont work';
		}
		return $overDue;
	}
	
	public static function deactivateAll($id){
		$db = Database::getDB ();
		try {
			$query = "UPDATE policies SET active =0 WHERE policyId = :policyId";
			 
			$statement = $db->prepare ($query);
			$statement->bindValue(":policyId", $id);
			$statement->execute ();
			$statement->closeCursor();
		} catch (Exception $e) {
			echo 'policies wont work';
		}
		$db = Database::getDB();
		try{
			$query = "UPDATE pets SET active =0 WHERE policyId =".$id;
			$statement = $db->prepare ($query);
			$statement->execute ();
			$statement->closeCursor();
			} catch (Exception $e) {
				echo 'pets wont work';
		}
		
		$db = Database::getDB();
		try{
			$query = "UPDATE users SET active =0 WHERE policyId =".$id;
			$statement = $db->prepare ($query);
			$statement->execute ();
			$statement->closeCursor();
		} catch (Exception $e) {
			echo 'users wont work';
		}
	}
	
	public static function getPolicyDetails(){
		$overDue= array();
		$db = Database::getDB();
		try{
			$query = 'SELECT * from policyDetails';
			$statement = $db->prepare ($query);
			$statement->execute ();
			$overDue = $statement->fetchAll(PDO::FETCH_ASSOC);
				
			$statement->closeCursor();
		} catch (Exception $e) {
			echo 'wont work';
		}
		return $overDue;
	}
    /*public static function updateAdmin($admin) {
        // Update a user
        try {
            $db = Database::getDB ();
            if (is_null($admin) || $admin->getErrorCount() > 0)
                return $admin;
            $checkAdmin = AdminDB::getAdminsBy('adminId', $admin->getAdminId());
            if (empty($checkAdmin))
                $admin->setError('adminId', 'BILL_DOES_NOT_EXIST');
            if ($admin->getErrorCount() > 0)
                return $admin;

            $query = "UPDATE Admins SET status = :status, :balance=>balance WHERE adminId = :adminId";

            $statement = $db->prepare ($query);
            $statement->bindValue(":status", $admin->getStatus());
            $statement->bindValue(":balance", $admin->getBalance());
            $statement->execute ();
            $statement->closeCursor();
        } catch (Exception $e) { // Not permanent error handling
            $admin->setError('adminId', 'BILL_COULD_NOT_BE_UPDATED');
        }
        return $admin;
    }*/
}

?>