<?php

class CareTakersDB
{

    public static function addCareTakers($careTaker)
    {
        // Inserts $review into the Reviews table and returns reviewId
        $query = "INSERT INTO CareTakers (petId, userId, isPrimaryOwner,active)
		                      VALUES(:petId, :userId, :isPrimaryOwner,:active)";
        try {
            $db = Database::getDB();
            if (is_null($careTaker) || $careTaker->getErrorCount() > 0)
                return $careTaker;

            $statement = $db->prepare($query);
            $statement->bindValue(":petId", $careTaker->getPetId());
            $statement->bindValue(":userId", $careTaker->getUserId());
            $statement->bindValue(":isPrimaryOwner", $careTaker->getIsPrimaryOwner());
            $statement->bindValue(":active", $careTaker->getActive());
            $statement->execute();
            $statement->closeCursor();
        } catch (Exception $e) { // Not permanent error handling
            $careTaker->setError('UserId', 'CARETAKER_INVALID');
        }
        return $careTaker;
    }

    public static function getCareTakersRowSetsBy($type = null, $value = null)
    {
        // Returns the rows of Users whose $type field has value $value
        $allowedTypes = ["userId", "petId"];
        $careTakersRowSets = array();
        try {
            $db = Database::getDB();
            $query = "SELECT userId, petId, isPrimaryOwner, active FROM CareTakers";
            if (!is_null($type)) {
                if (!in_array($type, $allowedTypes))
                    throw new PDOException("$type not an allowed search criterion for CareTakers");
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

    public static function getCareTakersArray($rowSets)
    {
        // Returns an array of User objects extracted from $rowSets
        $careTakers = array();
        if (!empty($rowSets)) {
            foreach ($rowSets as $careTakerRow) {
                $careTaker = new CareTakers($careTakerRow);
                $careTaker->setBillId($careTakerRow['careTakerId']);
                array_push($careTakers, $careTaker);
            }
        }
        return $careTakers;
    }

    public static function getCareTakersBy($type = null, $value = null)
    {
        // Returns User objects whose $type field has value $value
        $careTakerRows = BillDB::getBillRowSetsBy($type, $value);
        return BillDB::getCareTakersArray($careTakerRows);
    }

    public static function getBillValues($rowSets, $column)
    {
        // Returns an array of values from $column extracted from $rowSets
        $careTakerValues = array();
        foreach ($rowSets as $careTakerRow) {
            $careTakerValue = $careTakerRow[$column];
            array_push($careTakerValues, $careTakerValue);
        }
        return $careTakerValues;
    }

    public static function getBillValuesBy($column, $type = null, $value = null)
    {
        // Returns the $column of Users whose $type field has value $value
        $careTakerRows = BillDB::getBillRowSetsBy($type, $value);
        return BillDB::getBillValues($careTakerRows, $column);
    }

    /*public static function updateBill($careTaker) {
        // Update a user
        try {
            $db = Database::getDB ();
            if (is_null($careTaker) || $careTaker->getErrorCount() > 0)
                return $careTaker;
            $checkBill = BillDB::getCareTakersBy('careTakerId', $careTaker->getBillId());
            if (empty($checkBill))
                $careTaker->setError('careTakerId', 'CARETAKERS_DOES_NOT_EXIST');
            if ($careTaker->getErrorCount() > 0)
                return $careTaker;

            $query = "UPDATE CareTakers SET status = :status, :balance=>balance WHERE careTakerId = :careTakerId";

            $statement = $db->prepare ($query);
            $statement->bindValue(":status", $careTaker->getStatus());
            $statement->bindValue(":balance", $careTaker->getBalance());
            $statement->execute ();
            $statement->closeCursor();
        } catch (Exception $e) { // Not permanent error handling
            $careTaker->setError('careTakerId', 'BILL_COULD_NOT_BE_UPDATED');
        }
        return $careTaker;
    }*/
}

?>