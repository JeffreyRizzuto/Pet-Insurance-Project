<?php

class Policies
{
    private $errorCount;
    private $errors;
    private $formInput;
    private $policyId;
    private $totalAmount;
    private $policyNumber;
    private $startDate;
    private $endDate;
    private $active;
    private $paymentOption;


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
            $this->validatePolicyId();
            $this->validateTotalAmount();
            $this->validatePolicyNumber();
            $this->validateStartDate();
            $this->validateEndDate();
            $this->validateActive();
            $this->validatePaymentOption();
        }
    }

    private function initializeEmpty()
    {
        $this->errorCount = 0;
        $errors = array();
        $this->policyId = "";
        $this->totalAmount = "";
        $this->policyNumber = "";
        $this->statDate = "";
        $this->endDate = "";
        $this->active = "";
        $this->paymentOption = "";
    }

    private function validatePolicyId()
    {
        $this->policyId = $this->extractForm('policyId');
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

    private function validateTotalAmount()
    {
        $this->totalAmount = $this->extractForm('totalAmount');
    }

    private function validatePolicyNumber()
    {
        $this->policyNumber = $this->extractForm('policyNumber');
    }

    private function validateEndDate()
    {
        $this->endDate = $this->extractForm('endDate');
    }

    private function validateActive()
    {
        $this->active = $this->extractForm('active');
    }

    private function validatePaymentOption()
    {
        $this->paymentOption = $this->extractForm('paymentOption');
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

    public function getPolicyId()
    {
        return $this->policyId;
    }

    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    public function getPolicyNumber()
    {
        return $this->policyNumber;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function getPaymentOption()
    {
        return $this->paymentOption;
    }

    public function getParameters()
    {
        // Return data fields as an associative array
        $paramArray = array("policyId" => $this->policyId,
            "totalAmount" => $this->totalAmount,
            "policyNumber" => $this->policyNumber,
            "startDate" => $this->startDate,
            "endDate" => $this->endDate,
            "active" => $this->active,
            "paymentOption" => $this->paymentOption
        );
        return $paramArray;
    }

    public function setError($errorName, $errorValue)
    {
        // Set a particular error value and increments error count
        $this->errors[$errorName] = Messages::getError($errorValue);
        $this->errorCount++;
    }

    public function setPolicyId($id)
    {
        // Set the value of the userId to $id
        $this->policyId = $id;
    }

    public function __toString()
    {
        $str = "policyId" . $this->policyId .
            "totalAmount" . $this->totalAmount .
            "policyNumber" . $this->policyNumber .
            "startDate" . $this->startDate .
            "endDate" . $this->endDate .
            "active" . $this->active .
            "paymentOption" . $this->paymentOption;
        return $str;
    }

    private function validateStartDate()
    {
        $this->startDate = $this->extractForm('startDate');
    }
}

?>