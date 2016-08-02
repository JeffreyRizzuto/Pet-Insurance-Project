<?php

class Bills
{
    private $errorCount;
    private $errors;
    private $formInput;
    private $billId;
    private $dueDate;
    private $policyId;
    private $minimumPayment;
    private $status;
    private $balance;

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
            $this->validateBillId();
            $this->validatePolicyId();
            $this->validateDueDate();
            $this->validateMinimumPayment();
            $this->validateStatus();
            $this->validateBalance();
        }
    }

    private function initializeEmpty()
    {
        $this->billId = "";
        $this->policyId = "";
        $this->dueDate = "";
        $this->minimumPayment = "";
        $this->status = "";
        $this->balance = "";
    }

    private function validateBillId()
    {
        // Username should only contain letters, numbers, dashes and underscore
        $this->billId = $this->extractForm('billId');
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

    private function validateDueDate()
    {
        // Username should only contain letters, numbers, dashes and underscore
        $this->isDueDate = $this->extractForm('dueDate');
    }

    private function validateMinimumPayment()
    {
        $this->minimumPayment = $this->extractForm('minimumPayment');
    }

    private function validateStatus()
    {
        $this->status = $this->extractForm('status');
    }

    private function validateBalance()
    {
        $this->balance = $this->extractForm('balance');
    }
    
    private function validatePolicyId(){
    	$this->policyId = $this->extractForm("policyId");
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

    public function getBillId()
    {
        return $this->billId;
    }

    public function setBillId($id)
    {
        // Set the value of the userId to $id
        $this->billId = $id;
    }

    public function getDueDate()
    {
        return $this->dueDate;
    }

    public function getPolicyId()
    {
        return $this->policyId;
    }

    public function getMinimumPayment()
    {
        return $this->minimumPayment;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function getParameters()
    {
        // Return data fields as an associative array
        $paramArray = array("billId" => $this->billId,
            "policyId" => $this->policyId,
            "duedate" => $this->dueDate,
            "minimumPayment" => $this->minimumPayment,
            "status" => $this->status,
            "balance" => $this->balance
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
        $str = "billId" . $this->billId .
            "policyId" . $this->policyId .
            "duedate" . $this->dueDate .
            "minimumPayment" . $this->minimumPayment .
            "status" . $this->status .
            "balance" . $this->balance;
        return $str;
    }

    private function validateUserId()
    {
        // Username should only contain letters, numbers, dashes and underscore
        $this->policyId = $this->extractForm('policyId');
    }
}

?>