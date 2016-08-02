<?php

class PoliciesDB
{

    public static function addPolicy($policy)
    {
        // Inserts $review into the Reviews table and returns reviewId
        $query = "INSERT INTO Policies (totalAmount, policyNumber, startDate, endDate, active, paymentOption)
		                      VALUES(:totalAmount, :policyNumber, :startDate, :endDate, :active, :paymentOption)";
        try {
            $db = Database::getDB();
            if (is_null($policy) || $policy->getErrorCount() > 0)
                return $policy;

            $statement = $db->prepare($query);
            $statement->bindValue(":totalAmount", $policy->getTotalAmount());
            $statement->bindValue(":policyNumber", $policy->getPolicyNumber());
            $statement->bindValue(":startDate", $policy->getStartDate());
            $statement->bindValue(":endDate", $policy->getEndDate());
            $statement->bindValue(":active", $policy->getActive());
            $statement->bindValue(":paymentOption", $policy->getPaymentOption());
            $statement->execute();
            $statement->closeCursor();
            $policy->setPolicyId($db->lastInsertId("policyId"));
        } catch (Exception $e) { // Not permanent error handling
            $policy->setError('policyId', 'LIST_INVALID');
        }
        return $policy;
    }

    public static function getPolicyRowSetsBy($type = null, $value = null)
    {
        // Returns the rows of Users whose $type field has value $value
        $allowedTypes = ["policyId", "policyNumber"];
        $careTakersRowSets = array();
        try {
            $db = Database::getDB();
            $query = "SELECT policyId, totalAmount, policyNumber, startDate, endDate, active, paymentOption FROM Policies";
            if (!is_null($type)) {
                if (!in_array($type, $allowedTypes))
                    throw new PDOException("$type not an allowed search criterion for Policies");
                $query = $query . " WHERE ($type = :$type)";
                $statement = $db->prepare($query);
                $statement->bindParam(":$type", $value);
            } else
                $statement = $db->prepare($query);
            $statement->execute();
            $careTakersRowSets = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement->closeCursor();
        } catch (Exception $e) { // Not permanent error handling
            echo "<p>Error getting user rows by $type: " . $e->getMessage() . "</p>";
        }
        return $careTakersRowSets;
    }

    public static function getPoliciesArray($rowSets)
    {
        // Returns an array of User objects extracted from $rowSets
        $policies = array();
        if (!empty($rowSets)) {
            foreach ($rowSets as $policyRow) {
                $policy = new Policies($policyRow);
                $policy->setPolicyId($policyRow['policyId']);
                array_push($policies, $policy);
            }
        }
        return $policies;
    }

    public static function getPoliciesBy($type = null, $value = null)
    {
        // Returns User objects whose $type field has value $value
        $policyRows = PoliciesDB::getPolicyRowSetsBy($type, $value);
        return PoliciesDB::getPoliciesArray($policyRows);
    }

    public static function getPolicyValues($rowSets, $column)
    {
        // Returns an array of values from $column extracted from $rowSets
        $policyValues = array();
        foreach ($rowSets as $policyRow) {
            $policyValue = $policyRow[$column];
            array_push($policyValues, $policyValue);
        }
        return $policyValues;
    }

    public static function getPolicyValuesBy($column, $type = null, $value = null)
    {
        // Returns the $column of Users whose $type field has value $value
        $policyRows = PolicyDB::getPolicyRowSetsBy($type, $value);
        return PolicyDB::getPolicyValues($policyRows, $column);
    }

    /*public static function updatePolicy($policy) {
        // Update a user
        try {
            $db = Database::getDB ();
            if (is_null($policy) || $policy->getErrorCount() > 0)
                return $policy;
            $checkPolicy = PolicyDB::getPoliciesBy('policyId', $policy->getPolicyId());
            if (empty($checkPolicy))
                $policy->setError('policyId', 'BILL_DOES_NOT_EXIST');
            if ($policy->getErrorCount() > 0)
                return $policy;

            $query = "UPDATE Policies SET status = :status, :balance=>balance WHERE policyId = :policyId";

            $statement = $db->prepare ($query);
            $statement->bindValue(":status", $policy->getStatus());
            $statement->bindValue(":balance", $policy->getBalance());
            $statement->execute ();
            $statement->closeCursor();
        } catch (Exception $e) { // Not permanent error handling
            $policy->setError('policyId', 'BILL_COULD_NOT_BE_UPDATED');
        }
        return $policy;
    }*/
}

?>