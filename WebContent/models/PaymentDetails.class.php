<?php

class PaymentDetails
{
    private $errorCount;
    private $errors;
    private $formInput;
    private $paymentDetailsId;
    private $billId;
    private $firstName;
    private $lastName;
    private $debitOrCredit;
    private $cardType;
    private $cardNumber;
    private $zipcode;
    private $expirationDate;

    public function __construct($formInput = null)
    {
        $this->formInput = $formInput;
        Messages::reset();
        $this->initialize();
    }

    private function initialize()
    {
        $this->errorCount = 0;
        $this->errors = array();
        if (is_null($this->formInput))
            $this->initializeEmpty();
        else {
            $this->validatePaymentDetailsId();
            $this->validateBillId();
            $this->validateFirstName();
            $this->validateLastName();
            $this->validateDebitOrCredit();
            $this->validateCardType();
            $this->validateCardNumber();
            $this->validateZipcode();
            $this->validateExpirationDate();
        }
    }

    private function initializeEmpty()
    {
    	$this->errorCount = 0;
    	$errors = array();
        $this->paymentDetailsId = "";
        $this->billId = "";
        $this->firstName = "";
        $this->lastName = "";
        $this->debitOrCredit = "";
        $this->cardType = "";
        $this->cardNumber = "";
        $this->zipcode = "";
        $this->expirationDate = "";
    }

    private function validatePaymentDetailsId()
    {
        // Username should only contain letters, numbers, dashes and underscore
        $this->paymentDetailsId = $this->extractForm('paymentDetailsId');
    }

    private function extractForm($valueName)
    {
        // Extract a stripped value from the form array
        $value = "";
        if (isset($this->formInput[$valueName])) {
            $value = trim($this->formInput[$valueName]);
            $value = stripslashes($value);
            $value = htmlspecialchars($value);
            return $value;
        }
    }

    private function validateBillId()
    {
        // Username should only contain letters, numbers, dashes and underscore
        $this->billId = $this->extractForm('billId');
    }

    private function validateFirstName()
    {
        // Username should only contain letters, numbers, dashes and underscore
        $this->firstName = $this->extractForm('firstName');
    }
    
    private function validateLastName()
    {
    	// Username should only contain letters, numbers, dashes and underscore
    	$this->lastName = $this->extractForm('lastName');
    }

    private function validateDebitOrCredit()
    {
        $this->debitOrCredit = $this->extractForm('debitOrCredit');
    }

    private function validateCardType()
    {
        $this->cardType = $this->extractForm('cardType');
    }

    private function validateCardNumber()
    {
        $this->cardNumber = $this->extractForm('cardNumber');
    }

    private function validateZipcode()
    {
        $this->zipcode = $this->extractForm('zipcode');
    }

    private function validateExpirationDate()
    {
        $this->expirationDate = $this->extractForm('expirationDate');
    }

    public function getError($errorName)
    {
        // Return the error string associated with $errorName
        if (isset($this->errors[$errorName]))
            return $this->errors[$errorName];
        else
            return "";
    }

    public function getErrorCount()
    {
        return $this->errorCount;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getPaymentDetailsId()
    {
        return $this->paymentDetailsId;
    }

    public function getBillId()
    {
        return $this->billId;
    }

    public function setPaymentDetailsId($id)
    {
        // Set the value of the userId to $id
        $this->paymentDetailsId = $id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getDebitOrCredit()
    {
        return $this->debitOrCredit;
    }

    public function getCardType()
    {
        return $this->cardType;
    }

    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    public function getZipcode()
    {
        return $this->zipcode;
    }

    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    public function getParameters()
    {
        // Return data fields as an associative array
        $paramArray = array("paymentDeailsId" => $this->paymentDetailsId,
            "billId" => $this->billId,
            "firstName" => $this->firstName,
            "lastName" => $this->lastName,
            "debitOrCredit" => $this->debitOrCredit,
            "cardType" => $this->cardType,
            "zipCode" => $this->zipCode,
            "expirationDate" . $this->exerationDate
        );
        return $paramArray;
    }

    public function setError($errorName, $errorValue)
    {
        // Set a particular error value and increments error count
        $this->errors[$errorName] = Messages::getError($errorValue);
        $this->errorCount++;
    }

    public function __toString()
    {
        $str = "paymentDeailsId" . $this->paymentDetailsId .
            "billId" . $this->billId .
            "firstName" . $this->firstName .
            "lastName" . $this->lastName .
            "debitOrCredit" . $this->debitOrCredit .
            "cardType" . $this->cardType .
            "cardNumber" . $this->cardNumber .
            "zipCode" . $this->zipCode .
            "expirationDate" . $this->exerationDate;
        return $str;
    }

}

?>