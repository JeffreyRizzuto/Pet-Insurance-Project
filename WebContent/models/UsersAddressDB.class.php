<?php

class UsersAddressDB
{

    public static function addAddress($address)
    {
        // Inserts $review into the Reviews table and returns reviewId
        $query = "INSERT INTO UserAddresses (userId, address, city, zipcode, state, isPetAddress)
		                      VALUES(:userId, :address, :city, :zipcode, :state, :isPetAddress)";
        try {
            $db = Database::getDB();
            if (is_null($address) || $address->getErrorCount() > 0)
                return $address;
            $statement = $db->prepare($query);
            $statement->bindValue(":userId", $address->getUserId());
            $statement->bindValue(":address", $address->getAddress());
            $statement->bindValue(":city", $address->getCity());
            $statement->bindValue(":zipcode", $address->getZipcode());
            $statement->bindValue(":state", $address->getState());
            $statement->bindValue(":isPetAddress", $address->getIsPetAddress());
            $statement->execute();
            $statement->closeCursor();
            $address->setAddressId($db->lastInsertId("addressId"));
        } catch (Exception $e) { // Not permanent error handling
            $address->setError('addressId', 'LIST_INVALID');
        }
        return $address;
    }

    public static function getAddressRowSetsBy($type = null, $value = null)
    {
        // Returns the rows of Users whose $type field has value $value
        $allowedTypes = ["addressId", "userId"];
        $addressRowSets = array();
        try {
            $db = Database::getDB();
            $query = "SELECT userId, address, city, zipcode, state, isPetAddress, addressId FROM UserAddresses";
            if (!is_null($type)) {
                if (!in_array($type, $allowedTypes))
                    throw new PDOException("$type not an allowed search criterion for UserAddresses");
                $query = $query . " WHERE ($type = :$type)";
                $statement = $db->prepare($query);
                $statement->bindParam(":$type", $value);
            } else
                $statement = $db->prepare($query);
            $statement->execute();
            $addressRowSets = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement->closeCursor();
        } catch (Exception $e) { // Not permanent error handling
            echo "<p>Error getting user rows by $type: " . $e->getMessage() . "</p>";
        }
        return $addressRowSets;
    }

    public static function getAddresssArray($rowSets)
    {
        // Returns an array of Address objects extracted from $rowSets
        $addresss = array();
        if (!empty($rowSets)) {
            foreach ($rowSets as $addressRow) {
                $address = new UsersAddress($addressRow);
                $address->setAddressId($addressRow['addressId']);
                array_push($addresss, $address);
            }
        }
        return $addresss;
    }

    public static function getAddressesBy($type = null, $value = null)
    {
        // Returns Address objects whose $type field has value $value
        $addressRows = UsersAddressDB::getAddressRowSetsBy($type, $value);
        return UsersAddressDB::getAddresssArray($addressRows);
    }

    public static function getAddressValues($rowSets, $column)
    {
        // Returns an array of values from $column extracted from $rowSets
        $addressValues = array();
        foreach ($rowSets as $addressRow) {
            $addressValue = $addressRow[$column];
            array_push($addressValues, $addressValue);
        }
        return $addressValues;
    }

    public static function getAddressValuesBy($column, $type = null, $value = null)
    {
        // Returns the $column of Addresss whose $type field has value $value
        $addressRows = UsersAddressDB::getAddressRowSetsBy($type, $value);
        return UsersAddressDB::getAddressValues($addressRows, $column);
    }

    /*public static function updateAddress($address) {
        // Update a address
        try {
            $db = Database::getDB ();
            if (is_null($address) || $address->getErrorCount() > 0)
                return $address;
            $checkAddress = AddressDB::getAddresssBy('addressId', $address->getAddressId());
            if (empty($checkAddress))
                $address->setError('addressId', 'BILL_DOES_NOT_EXIST');
            if ($address->getErrorCount() > 0)
                return $address;

            $query = "UPDATE Addresss SET status = :status, :balance=>balance WHERE addressId = :addressId";

            $statement = $db->prepare ($query);
            $statement->bindValue(":status", $address->getStatus());
            $statement->bindValue(":balance", $address->getBalance());
            $statement->execute ();
            $statement->closeCursor();
        } catch (Exception $e) { // Not permanent error handling
            $address->setError('addressId', 'BILL_COULD_NOT_BE_UPDATED');
        }
        return $address;
    }*/
}

?>