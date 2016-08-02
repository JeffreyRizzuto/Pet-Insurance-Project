<?php

class PaymentDetailsDB
{

    public static function addPaymentDetail($paymentDetail)
    {
        // Inserts $review into the Reviews table and returns reviewId
        $query = "INSERT INTO PaymentDetails (billId, firstName, lastName, debitOrCredit, cardType, cardNumber, zipcode, expirationDate)
		                      VALUES(:billId, :firstName, :lastName, :debitOrCredit, :cardType, :cardNumber,:zipcode, :expirationDate)";
        try {
            $db = Database::getDB();
            if (is_null($paymentDetail) || $paymentDetail->getErrorCount() > 0)
                return $paymentDetail;

            $statement = $db->prepare($query);
            $statement->bindValue(":billId", $paymentDetail->getBillId());
            $statement->bindValue(":firstName", $paymentDetail->getFirstName());
            $statement->bindValue(":lastName", $paymentDetail->getLastName());
            $statement->bindValue(":debitOrCredit", $paymentDetail->getDebitOrCredit());
            $statement->bindValue(":cardType", $paymentDetail->getCardType());
            $statement->bindValue(":cardNumber", $paymentDetail->getCardNumber());
            $statement->bindValue(":zipCode", $paymentDetail->getZipcode());
            $statement->bindValue(":expirationDate", $paymentDetail->getExpirationDate());
            $statement->execute();
            $statement->closeCursor();
            $paymentDetail->setPaymentDetailsId($db->lastInsertId("paymentDetailsId"));
        } catch (Exception $e) { // Not permanent error handling
            $paymentDetail->setError('paymentDetailId', 'LIST_INVALID');
        }
        return $paymentDetail;
    }

    public static function getPaymentDetailRowSetsBy($type = null, $value = null)
    {
        // Returns the rows of Users whose $type field has value $value
        $allowedTypes = ["paymentDetailId", "billId", "policyId"];
        $typeAlias = array("policyId" => "Bills.policyId");
        $paymentDetailRowSets = array();
        try {
            $db = Database::getDB();
            $query = "SELECT PaymentDetails.billId, PaymentDetails.firstName, PaymentDetails.lastName, PaymentDetails.debitOrCredit, PaymentDetails.number, PaymentDetails.zipcode
					Bills.policyId as policyId FROM PaymentDetails LEFT JOIN Bills ON PaymentDetails.billId = Bills.billId";
            if (!is_null($type)) {
                if (!in_array($type, $allowedTypes))
                    throw new PDOException("$type not an allowed search criterion for PaymentDetails");
                $typeValue = (isset($typeAlias[$type])) ? $typeAlias[$type] : $type;
                $query = $query . " WHERE ($typeValue = :$type)";
                $statement = $db->prepare($query);
                $statement->bindParam(":$type", $value);
            } else
                $statement = $db->prepare($query);
            $statement->execute();
            $paymentDetailRowSets = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement->closeCursor();
        } catch (Exception $e) { // Not permanent error handling
            echo "<p>Error getting user rows by $type: " . $e->getMessage() . "</p>";
        }
        return $paymentDetailRowSets;
    }

    public static function getPaymentDetailsArray($rowSets)
    {
        // Returns an array of User objects extracted from $rowSets
        $paymentDetails = array();
        if (!empty($rowSets)) {
            foreach ($rowSets as $paymentDetailRow) {
                $paymentDetail = new PaymentDetails($paymentDetailRow);
                $paymentDetail->setPaymentDetailId($paymentDetailRow['paymentDetailId']);
                array_push($paymentDetails, $paymentDetail);
            }
        }
        return $paymentDetails;
    }

    public static function getPaymentDetailsBy($type = null, $value = null)
    {
        // Returns User objects whose $type field has value $value
        $paymentDetailRows = PaymentDetailDB::getPaymentDetailRowSetsBy($type, $value);
        return PaymentDetailDB::getPaymentDetailsArray($paymentDetailRows);
    }

    public static function getPaymentDetailValues($rowSets, $column)
    {
        // Returns an array of values from $column extracted from $rowSets
        $paymentDetailValues = array();
        foreach ($rowSets as $paymentDetailRow) {
            $paymentDetailValue = $paymentDetailRow[$column];
            array_push($paymentDetailValues, $paymentDetailValue);
        }
        return $paymentDetailValues;
    }

    public static function getPaymentDetailValuesBy($column, $type = null, $value = null)
    {
        // Returns the $column of Users whose $type field has value $value
        $paymentDetailRows = PaymentDetailDB::getPaymentDetailRowSetsBy($type, $value);
        return PaymentDetailDB::getPaymentDetailValues($paymentDetailRows, $column);
    }

    /*public static function updatePaymentDetail($paymentDetail) {
        // Update a user
        try {
            $db = Database::getDB ();
            if (is_null($paymentDetail) || $paymentDetail->getErrorCount() > 0)
                return $paymentDetail;
            $checkPaymentDetail = PaymentDetailDB::getPaymentDetailsBy('paymentDetailId', $paymentDetail->getPaymentDetailId());
            if (empty($checkPaymentDetail))
                $paymentDetail->setError('paymentDetailId', 'BILL_DOES_NOT_EXIST');
            if ($paymentDetail->getErrorCount() > 0)
                return $paymentDetail;

            $query = "UPDATE PaymentDetails SET status = :status, :balance=>balance WHERE paymentDetailId = :paymentDetailId";

            $statement = $db->prepare ($query);
            $statement->bindValue(":status", $paymentDetail->getStatus());
            $statement->bindValue(":balance", $paymentDetail->getBalance());
            $statement->execute ();
            $statement->closeCursor();
        } catch (Exception $e) { // Not permanent error handling
            $paymentDetail->setError('paymentDetailId', 'BILL_COULD_NOT_BE_UPDATED');
        }
        return $paymentDetail;
    }*/
}

?>