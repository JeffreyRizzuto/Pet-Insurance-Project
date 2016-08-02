<?php

class UsersDB
{

    public static function addUser($user)
    {
        // Inserts $review into the Reviews table and returns reviewId
        $query = "INSERT INTO Users (firstName, lastName, userName, password, email, gender, phoneNumber, ssn,birthday,isPrimaryPolicyHolder,relationWithPrimaryPolicyHolder,policyId,active)
		                      VALUES(:firstName, :lastName, :userName, :password, :email, :gender, :phoneNumber, :ssn,:birthday,:isPrimaryPolicyHolder,:relationWithPrimaryPolicyHolder,:policyId,:active)";
        try {
            $db = Database::getDB();
            if (is_null($user) || $user->getErrorCount() > 0)
                return $user;

            $statement = $db->prepare($query);
            $statement->bindValue(":firstName", $user->getFirstName());
            $statement->bindValue(":lastName", $user->getLastName());
            $statement->bindValue(":userName", $user->getUserName());
            $statement->bindValue(":password", $user->getPassword());
            $statement->bindValue(":email", $user->getEmail());
            $statement->bindValue(":gender", $user->getGender());
            $statement->bindValue(":phoneNumber", $user->getPhoneNumber());
            $statement->bindValue(":ssn", $user->getSsn());
            $statement->bindValue(":birthday", $user->getBirthday());
            $statement->bindValue(":isPrimaryPolicyHolder", $user->getIsPrimaryPolicyHolder());
            $statement->bindValue(":relationWithPrimaryPolicyHolder", $user->getRelationWithPrimaryPolicyHolder());
            $statement->bindValue(":policyId", $user->getPolicyId());
            $statement->bindValue(":active", $user->getActive());
            $statement->execute();
            $statement->closeCursor();
            $user->setUserId($db->lastInsertId("userId"));
        } catch (Exception $e) { // Not permanent error handling
            $user->setError('userId', 'USER_INVALID');
        }
        return $user;
    }

    public static function getUserValuesBy($column, $type = null, $value = null)
    {
        // Returns the $column of Users whose $type field has value $value
        $userRows = UsersDB::getUserRowSetsBy($type, $value);
        return UsersDB::getUserValues($userRows, $column);
    }

    public static function getUserRowSetsBy($type = null, $value = null)
    {
        // Returns the rows of Users whose $type field has value $value
        $allowedTypes = ["policyId", "userId", "petId", "userName"];
        $typeAlias = array("petId" => "Pets.petId", "policyId" => "Users.policyId");
        $userRowSets = array();
        try {
            $db = Database::getDB();
            $query = "SELECT Users.userId, Users.firstName, Users.lastName, Users.userName, Users.password, Users.email, Users.gender,Users.phoneNumber,Users.Ssn,
					Users.birthday, Users.isPrimaryPolicyHolder, Users.relationWithPrimaryPolicyHolder, Users.policyId, Users.active,
					Pets.petId as petId FROM Users LEFT JOIN Pets ON Users.policyID = Pets.policyId";
            if (!is_null($type)) {
                if (!in_array($type, $allowedTypes))
                    throw new PDOException("$type not an allowed search criterion for Users");
                $typeValue = (isset($typeAlias[$type])) ? $typeAlias[$type] : $type;
                $query = $query . " WHERE ($typeValue = :$type)";
                $statement = $db->prepare($query);
                $statement->bindParam(":$type", $value);
            } else
                $statement = $db->prepare($query);
            $statement->execute();
            $userRowSets = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement->closeCursor();
        } catch (Exception $e) { // Not permanent error handling
            echo "<p>Error getting user rows by $type: " . $e->getMessage() . "</p>";
        }
        return $userRowSets;
    }

    public static function getUserValues($rowSets, $column)
    {
        // Returns an array of values from $column extracted from $rowSets
        $userValues = array();
        foreach ($rowSets as $userRow) {
            $userValue = $userRow[$column];
            array_push($userValues, $userValue);
        }
        return $userValues;
    }

    public static function updateUser($user)
    {
        // Update a user
        try {
            $db = Database::getDB();
            if (is_null($user) || $user->getErrorCount() > 0)
                return $user;
            $checkUser = UsersDB::getUsersBy('userId', $user->getUserId());
            if (empty($checkUser))
                $user->setError('userId', 'USER_DOES_NOT_EXIST');
            if ($user->getErrorCount() > 0)
                return $user;

            $query = "UPDATE Users SET email = :email, phoneNumber = :phoneNumber, userName = :userName WHERE userId = :userId";

            $statement = $db->prepare($query);
            $statement->bindValue(":email", $user->getEmail());
            $statement->bindValue(":phoneNumber", $user->getPhoneNumber());
            $statement->bindValue(":userName", $user->getUserName());
            $statement->bindValue(":userId", $user->getUserId());
            $statement->execute();
            $statement->closeCursor();
        } catch (Exception $e) { // Not permanent error handling
            $user->setError('userId', 'USER_COULD_NOT_BE_UPDATED');
        }
        return $user;
    }

    public static function getUsersBy($type = null, $value = null)
    {
        // Returns User objects whose $type field has value $value
        $userRows = UsersDB::getUserRowSetsBy($type, $value);
        return UsersDB::getUsersArray($userRows);
    }

    public static function getUsersArray($rowSets)
    {
        // Returns an array of User objects extracted from $rowSets
        $users = array();
        if (!empty($rowSets)) {
            foreach ($rowSets as $userRow) {
                $user = new Users($userRow);
                $user->setUserId($userRow['userId']);
                array_push($users, $user);
            }
        }
        return $users;
    }
}

?>