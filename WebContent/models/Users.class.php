<?php

class Users
{
    private $errorCount;
    private $errors;
    private $formInput;
    private $firstName;
    private $lastName;
    private $userName;
    private $password;
    private $email;
    private $gender;
    private $phoneNumber;
    private $ssn;
    private $birthday;
    private $isPrimaryPolicyHolder;
    private $relationWithPrimaryPolicyHolder;
    private $policyId;
    private $active;
    private $userId;

    public function __construct($formInput = null)
    {
        $this->formInput = $formInput;
        Messages::reset();
        $this->initialize();
    }

    private function initialize()
    {
        $this->errorCount = 0;
        $errors = array();
        if (is_null($this->formInput))
            $this->initializeEmpty();
        else {
            $this->validateUserId();
            $this->validateEmail();
            $this->validateGender();
            $this->validateFirstName();
            $this->validateLastName();
            $this->validateUserName();
            $this->validatePassword();
            $this->validateFavoriteColor();
            $this->validateSsn();
            $this->validatePhoneNumber();
            $this->validateBirthDay();
            $this->validateIsPrimaryPolicyHolder();
            $this->validateRelationWithPrimaryPolicyHolder();
            $this->validatePolicyId();
            $this->validateActive();
        }
    }

    private function initializeEmpty()
    {
        $this->errorCount = 0;
        $errors = array();
        $this->firstName = "First";
        $this->lastName = "Last";
        $this->email = "";
        $this->gender = "";
        $this->favoriteColor = "";
        $this->ssn = "";
        $this->phoneNumber = "";
        $this->gender = "";
        $this->userName = "";
        $this->password = "";
        $this->isPrimaryPolicyHolder = "";
        $this->relationWithPrimaryPolicyHolder = "";
        $this->policyId = NULL;
        $this->active = "";
    }

    private function validateUserId()
    {
        $this->userId = $this->extractForm('userId');
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

    private function validateEmail()
    {
        $this->email = $this->extractForm('email');
    }

    private function validateGender()
    {
        $this->gender = $this->extractForm('gender');

    }

    private function validateFirstName()
    {
        $this->firstName = $this->extractForm('firstName');
    }

    private function validateLastName()
    {
        $this->lastName = $this->extractForm('lastName');
    }

    private function validateUserName()
    {
        $this->userName = $this->extractForm('userName');
    }

    private function validatePassword()
    {
        $this->password = $this->extractForm('password');
    }

    private function validateFavoriteColor()
    {
        $this->favoriteColor = $this->extractForm('favoriteColor');
    }

    private function validateSsn()
    {
        $this->ssn = $this->extractForm('ssn');
    }

    private function validatePhoneNumber()
    {
        $this->phoneNumber = $this->extractForm('phoneNumber');
    }

    private function validateBirthday()
    {
        $this->birthday = $this->extractForm('birthday');
    }

    private function validateIsPrimaryPolicyHolder()
    {
        $this->isPrimaryPolicyHolder = $this->extractForm('isPrimaryPolicyHolder');
    }

    private function validateRelationWithPrimaryPolicyHolder()
    {
        $this->relationWithPrimaryPolicyHolder = $this->extractForm('relationWithPrimaryPolicyHolder');
    }

    private function validatePolicyId()
    {
        $this->policyId = $this->extractForm('policyId');
    }

    private function validateActive()
    {
        $this->active = $this->extractForm("active");
    }

    public function getError($errorName)
    {
        if (isset($this->errors[$errorName]))
            return $this->errors[$errorName];
        else
            return "";
    }

    public function setError($errorName, $errorValue)
    {
        // Sets a particular error value and increments error count
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

    public function getEmail()
    {
        return $this->email;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function getSsn()
    {
        return $this->ssn;
    }

    public function getIsPrimaryPolicyHolder()
    {
        return $this->isPrimaryPolicyHolder;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function getRelationWithPrimaryPolicyHolder()
    {
        return $this->relationWithPrimaryPolicyHolder;
    }

    public function getPolicyId()
    {
        return $this->policyId;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($id)
    {
        // Set the value of the userId to $id
        $this->userId = $id;
    }

    public function getParameters()
    {
        // Return data fields as an associative array
        $paramArray = array("firstName" => $this->firstName,
            "lastName" => $this->lastName,
            "email" => $this->email,
            "gender" => $this->gender,
            "userName" => $this->userName,
            "password" => $this->password,
            "phoneNumber" => $this->phoneNumber,
            "ssn" => $this->ssn,
            "birthday" => $this->birthday,
            "isPrimaryPolicyHolder" => $this->isPrimaryPolicyHolder,
            "relationWithPrimaryPolicyHolder" => $this->relationWithPrimaryPolicyHolder,
            "policyId" => $this->policyId,
            "active" => $this->active
        );
        return $paramArray;
    }

    public function __toString()
    {
        $str = "First name: " . $this->firstName .
            " Last name: " . $this->lastName .
            " Email: " . $this->email .
            " Gender: " . $this->gender .
            " UserName: " . $this->userName .
            " Password: " . $this->password .
            " PhoneNumber: " . $this->phoneNumber .
            " Ssn: " . $this->ssn .
            " Birthday: " . $this->birthday .
            " isPrimaryPolicyHolder: " . $this->isPrimaryPolicyHolder .
            " relationWithPrimaryPolicyHolder: " . $this->relationWithPrimaryPolicyHolder .
            " policyId: " . $this->policyId .
            " active: " . $this->active;
        return $str;
    }
}

?>