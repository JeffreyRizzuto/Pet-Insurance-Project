<?php

class CareTakers
{
    private $errorCount;
    private $errors;
    private $formInput;
    private $petId;
    private $userId;
    private $isPrimaryOwner;
    private $active;

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
            $this->validatePetId();
            $this->validateUserId();
            $this->validateIsPrimaryOwner();
            $this->validateActive();
        }
    }

    private function initializeEmpty()
    {
        $this->errorCount = 0;
        $errors = array();
        $this->petId = "";
        $this->userId = "";
        $this->isPrimaryOwner = "";
        $this->active = "";
    }

    private function validatePetId()
    {
        // Username should only contain letters, numbers, dashes and underscore
        $this->petId = $this->extractForm('petId');
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

    private function validateUserId()
    {
        // Username should only contain letters, numbers, dashes and underscore
        $this->userId = $this->extractForm('userId');
    }

    private function validateIsPrimaryOwner()
    {
        // Username should only contain letters, numbers, dashes and underscore
        $this->isPrimaryOwner = $this->extractForm('isPrimaryOwner');
    }

    private function validateActive()
    {
        $this->active = $this->extractForm('active');
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

    public function getPetId()
    {
        return $this->petId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getIsPrimaryOwner()
    {
        return $this->isPrimaryOwner;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function getParameters()
    {
        // Return data fields as an associative array
        $paramArray = array("petId" => $this->petId,
            "userId" => $this->userId,
            "isPrimaryOwner" => $this->isPrimaryOwner,
            "active" => $this->active
        );
        return $paramArray;
    }

    public function setError($errorName, $errorValue)
    {
        // Set a particular error value and increments error count
        $this->errors[$errorName] = Messages::getError($errorValue);
        $this->errorCount++;
    }

    public function setListId($id)
    {
        // Set the value of the userId to $id
        $this->policyId = $id;
    }

    public function __toString()
    {
        $str = "petId" . $this->petId .
            "userId" . $this->userId .
            "isPrimaryOwner" . $this->isPrimaryOwner .
            "active" . $this->active;
        return $str;
    }

}

?>