<?php

class BillsDB
{

    public static function addBill($bill)
    {
        // Inserts $review into the Reviews table and returns reviewId
        $query = "INSERT INTO Bills (dueDate, policyId, minimumPayment,status, balance)
		                      VALUES(:dueDate, :policyId, :minimumPayment,:status,:balance)";
        try {
            $db = Database::getDB();
            if (is_null($bill) || $bill->getErrorCount() > 0)
                return $bill;

            $statement = $db->prepare($query);
            $statement->bindValue(":dueDate", $bill->getUserDueDate());
            $statement->bindValue(":policyId", $bill->getPolicyId());
            $statement->bindValue(":minimumPayment", $bill->getMinimumPayment());
            $statement->bindValue(":status", $bill->getStatus());
            $statement->bindValue(":balance", $bill->getBalance());
            $statement->execute();
            $statement->closeCursor();
            $bill->setBillId($db->lastInsertId("billId"));
        } catch (Exception $e) { // Not permanent error handling
            $bill->setError('billId', 'LIST_INVALID');
        }
        return $bill;
    }

    public static function getBillRowSetsBy($type = null, $value = null)
    {
        // Returns the rows of Users whose $type field has value $value
        $allowedTypes = ["billId", "userId"];
        $typeAlias = array("userId" => "Users.userId");
        $billRowSets = array();
        try {
            $db = Database::getDB();
            $query = "SELECT Bills.dueDate, Bills.policyId, Bills.minimumPayment, Bills.status, Bills.balance
					Users.userId as userId FROM Bills LEFT JOIN Users ON Bills.policyId = Users.policyId";
            if (!is_null($type)) {
                if (!in_array($type, $allowedTypes))
                    throw new PDOException("$type not an allowed search criterion for Bills");
                $typeValue = (isset($typeAlias[$type])) ? $typeAlias[$type] : $type;
                $query = $query . " WHERE ($typeValue = :$type)";
                $statement = $db->prepare($query);
                $statement->bindParam(":$type", $value);
            } else
                $statement = $db->prepare($query);
            $statement->execute();
            $billRowSets = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement->closeCursor();
        } catch (Exception $e) { // Not permanent error handling
            echo "<p>Error getting user rows by $type: " . $e->getMessage() . "</p>";
        }
        return $billRowSets;
    }

    public static function getBillsArray($rowSets)
    {
        // Returns an array of User objects extracted from $rowSets
        $bills = array();
        if (!empty($rowSets)) {
            foreach ($rowSets as $billRow) {
                $bill = new Bills($billRow);
                $bill->setBillId($billRow['billId']);
                array_push($bills, $bill);
            }
        }
        return $bills;
    }

    public static function getBillsBy($type = null, $value = null)
    {
        // Returns User objects whose $type field has value $value
        $billRows = BillDB::getBillRowSetsBy($type, $value);
        return BillDB::getBillsArray($billRows);
    }

    public static function getBillValues($rowSets, $column)
    {
        // Returns an array of values from $column extracted from $rowSets
        $billValues = array();
        foreach ($rowSets as $billRow) {
            $billValue = $billRow[$column];
            array_push($billValues, $billValue);
        }
        return $billValues;
    }

    public static function getBillValuesBy($column, $type = null, $value = null)
    {
        // Returns the $column of Users whose $type field has value $value
        $billRows = BillDB::getBillRowSetsBy($type, $value);
        return BillDB::getBillValues($billRows, $column);
    }

    public static function updateBill($bill)
    {
        // Update a user
        try {
            $db = Database::getDB();
            if (is_null($bill) || $bill->getErrorCount() > 0)
                return $bill;
            $checkBill = BillDB::getBillsBy('billId', $bill->getBillId());
            if (empty($checkBill))
                $bill->setError('billId', 'BILL_DOES_NOT_EXIST');
            if ($bill->getErrorCount() > 0)
                return $bill;

            $query = "UPDATE Bills SET status = :status, :balance=>balance WHERE billId = :billId";

            $statement = $db->prepare($query);
            $statement->bindValue(":status", $bill->getStatus());
            $statement->bindValue(":balance", $bill->getBalance());
            $statement->execute();
            $statement->closeCursor();
        } catch (Exception $e) { // Not permanent error handling
            $bill->setError('billId', 'BILL_COULD_NOT_BE_UPDATED');
        }
        return $bill;
    }
    
    public static function getCurrent($id){

		$bill= array();
		$db = Database::getDB();
			try{
			$query = "SELECT * FROM bills WHERE billId in (SELECT max(billId) from bills where policyId = :policyId)";	
			$statement = $db->prepare ($query);
			$statement->bindValue(":policyId", $id);
			$statement->execute ();
			$bill = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			$statement->closeCursor();
				} catch (Exception $e) {
			echo 'wont work';
		}
		return $bill;
    	
    }
    
   
}

?>