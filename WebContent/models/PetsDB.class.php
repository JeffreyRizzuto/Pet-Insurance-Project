<?php

class PetsDB
{

    public static function addPet($pet)
    {
        // Inserts $review into the Reviews table and returns reviewId
        $query = "INSERT INTO Pets (policyID, breed, species, birthdate, color, length, height, weight,name,sex,active)
		                      VALUES(:policyID, :breed, :species, :birthdate, :color, :length, :height, :weight,:name,:sex,:active)";
        try {
            $db = Database::getDB();
            if (is_null($pet) || $pet->getErrorCount() > 0)
                return $pet;

            $statement = $db->prepare($query);
            $statement->bindValue(":policyID", $pet->getPolicyId());
            $statement->bindValue(":breed", $pet->getBreed());
            $statement->bindValue(":species", $pet->getSpecies());
            $statement->bindValue(":birthdate", $pet->getBirthdate());
            $statement->bindValue(":color", $pet->getColor());
            $statement->bindValue(":length", $pet->getLength());
            $statement->bindValue(":height", $pet->getHeight());
            $statement->bindValue(":weight", $pet->getWeight());
            $statement->bindValue(":name", $pet->getName());
            $statement->bindValue(":sex", $pet->getSex());
            $statement->bindValue(":active", $pet->getActive());
            $statement->execute();
            $statement->closeCursor();
            $pet->setPetId($db->lastInsertId("petId"));
        } catch (Exception $e) { // Not permanent error handling
            $pet->setError('petId', 'LIST_INVALID');
        }
        return $pet;
    }

    public static function getPetRowSetsBy($type = null, $value = null)
    {
        // Returns the rows of Users whose $type field has value $value
        $allowedTypes = ["policyId", "petId", "userId"];
        $typeAlias = array("userId" => "Users.policyId");
        $petRowSets = array();
        try {
            $db = Database::getDB();
            $query = "SELECT Pets.policyId, Pets.breed, Pets.species, Pets.birthdate, Pets.color, Pets.length,Pets.height,Pets.weight,
					Pets.name, Pets.sex, Pets.active
					Users.userId as userId FROM Pets LEFT JOIN Users ON Pets.policyID = Users.policyId";
            if (!is_null($type)) {
                if (!in_array($type, $allowedTypes))
                    throw new PDOException("$type not an allowed search criterion for Pets");
                $typeValue = (isset($typeAlias[$type])) ? $typeAlias[$type] : $type;
                $query = $query . " WHERE ($typeValue = :$type)";
                $statement = $db->prepare($query);
                $statement->bindParam(":$type", $value);
            } else
                $statement = $db->prepare($query);
            $statement->execute();
            $petRowSets = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement->closeCursor();
        } catch (Exception $e) { // Not permanent error handling
            echo "<p>Error getting user rows by $type: " . $e->getMessage() . "</p>";
        }
        return $petRowSets;
    }

    public static function getPetsArray($rowSets)
    {
        // Returns an array of User objects extracted from $rowSets
        $pets = array();
        if (!empty($rowSets)) {
            foreach ($rowSets as $petRow) {
                $pet = new Pets($petRow);
                $pet->setPetId($petRow['petId']);
                array_push($pets, $pet);
            }
        }
        return $pets;
    }

    public static function getPetsBy($type = null, $value = null)
    {
        // Returns User objects whose $type field has value $value
        $petRows = PetDB::getPetRowSetsBy($type, $value);
        return PetDB::getPetsArray($petRows);
    }

    public static function getPetValues($rowSets, $column)
    {
        // Returns an array of values from $column extracted from $rowSets
        $petValues = array();
        foreach ($rowSets as $petRow) {
            $petValue = $petRow[$column];
            array_push($petValues, $petValue);
        }
        return $petValues;
    }

    public static function getPetValuesBy($column, $type = null, $value = null)
    {
        // Returns the $column of Users whose $type field has value $value
        $petRows = PetDB::getPetRowSetsBy($type, $value);
        return PetDB::getPetValues($petRows, $column);
    }

    /*public static function updatePet($pet) {
        // Update a user
        try {
            $db = Database::getDB ();
            if (is_null($pet) || $pet->getErrorCount() > 0)
                return $pet;
            $checkPet = PetDB::getPetsBy('petId', $pet->getPetId());
            if (empty($checkPet))
                $pet->setError('petId', 'BILL_DOES_NOT_EXIST');
            if ($pet->getErrorCount() > 0)
                return $pet;

            $query = "UPDATE Pets SET status = :status, :balance=>balance WHERE petId = :petId";

            $statement = $db->prepare ($query);
            $statement->bindValue(":status", $pet->getStatus());
            $statement->bindValue(":balance", $pet->getBalance());
            $statement->execute ();
            $statement->closeCursor();
        } catch (Exception $e) { // Not permanent error handling
            $pet->setError('petId', 'BILL_COULD_NOT_BE_UPDATED');
        }
        return $pet;
    }*/
}

?>