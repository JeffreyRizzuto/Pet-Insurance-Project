<?php

class UsersAddress
{
    private $errorCount;
    private $errors;
    private $formInput;
    private $addressId;
    private $userId;
    private $address;
    private $city;
    private $zipcode;
    private $state;
    private $isPetAddress;

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
            $this->validateAddressId();
            $this->validateUserId();
            $this->validateAddress();
            $this->validateCity();
            $this->validateZipcode();
            $this->validateState();
            $this->validateIsPetAddress();
        }
    }

    private function initializeEmpty()
    {
        $this->errorCount = 0;
        $errors = array();
        $this->userId = "";
        $this->address = "";
        $this->city = "";
        $this->zipcode = "";
        $this->state = "";
        $this->isPetAddress = "";
    }

    private function validateAddressId()
    {
        // Username should only contain letters, numbers, dashes and underscore
        $this->addressId = $this->extractForm('addressId');
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

    private function validateAddress()
    {
        // Username should only contain letters, numbers, dashes and underscore
        $this->address = $this->extractForm('address');
    }

    private function validateCity()
    {
        $this->city = $this->extractForm('city');
    }

    private function validateZipcode()
    {
        $this->zipcode = $this->extractForm('zipcode');
    }

    private function validateState()
    {
        $this->state = $this->extractForm('state');
    }

    private function validateIsPetAddress()
    {
        $this->isPetAddress = $this->extractForm('isPetAddress');
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

    public function getAddressId()
    {
        return $this->addressId;
    }

    public function setAddressId($id)
    {
        // Set the value of the userId to $id
        $this->addressId = $id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getZipcode()
    {
        return $this->zipcode;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getIsPetAddress()
    {
        return $this->isPetAddress;
    }

    public function getParameters()
    {
        // Return data fields as an associative array
        $paramArray = array("addressId" => $this->addressId,
            "userId" => $this->userId,
            "address" => $this->address,
            "city" => $this->city,
            "zipcode" => $this->zipcode,
            "state" => $this->state,
            "isPetAddress" => $this->isPetAddress
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
        $str = "addressId: " . $this->addressId .
            " userId: " . $this->userId .
            " address: " . $this->address .
            " city: " . $this->city .
            " zipcode: " . $this->zipcode .
            " state: " . $this->state .
            " isPetAddress: " . $this->isPetAddress;
        return $str;
    }

}

?>