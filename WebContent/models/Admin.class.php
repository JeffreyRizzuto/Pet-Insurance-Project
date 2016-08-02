<?php

class Admin
{
    private $errorCount;
    private $errors;
    private $formInput;
    private $adminId;
    private $userName;
    private $password;

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
            $this->validateAdminId();
            $this->validateUserName();
            $this->validatePassword();
        }
    }

    private function initializeEmpty()
    {
        $this->errorCount = 0;
        $errors = array();
        $this->adminId = "";
        $this->userName = "";
        $this->password = "";
    }

    private function validateAdminId()
    {
        // Username should only contain letters, numbers, dashes and underscore
        $this->adminId = $this->extractForm('adminId');
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

    private function validateUserName()
    {
        // Username should only contain letters, numbers, dashes and underscore
        $this->userName = $this->extractForm('userName');
    }

    private function validatePassword()
    {
        // Username should only contain letters, numbers, dashes and underscore
        $this->password = $this->extractForm('password');
    }

    public function getError($errorName)
    {
        // Return the error string associated with $errorName
        if (isset($this->errors[$errorName]))
            return $this->errors[$errorName];
        else
            return "";
    }

    public function setError($errorName, $errorValue)
    {
        // Set a particular error value and increments error count
        $this->errors[$errorName] = Messages::getError($errorValue);
        $this->errorCount++;
    }

    public function getErrorCount()
    {
        return $this->errorCount;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getAdminId()
    {
        return $this->adminId;
    }

    public function setAdminId($id)
    {
        // Set the value of the userId to $id
        $this->adminId = $id;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getParameters()
    {
        // Return data fields as an associative array
        $paramArray = array("adminId" => $this->adminId,
            "userName" => $this->userName,
            "password" => $this->password
        );
        return $paramArray;
    }

    public function __toString()
    {
        $str = "adminId" . $this->adminId .
            "userName" . $this->userName .
            "password" . $this->password;
        return $str;
    }

}

?>