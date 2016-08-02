<?php

class Pets
{
    private $errorCount;
    private $errors;
    private $formInput;
    private $petId;
    private $policyId;
    private $breed;
    private $species;
    private $birthdate;
    private $color;
    private $length;
    private $height;
    private $weight;
    private $name;
    private $sex;
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
            $this->validatePolicyId();
            $this->validateBreed();
            $this->validateSpecies();
            $this->validateBirthdate();
            $this->validateColor();
            $this->validateLength();
            $this->validateHeight();
            $this->validateWeight();
            $this->validateName();
            $this->validateSex();
            $this->validateActive();
        }
    }

    private function initializeEmpty()
    {
        $this->errorCount = 0;
        $errors = array();
        $this->policyId = null;
        $this->breed = "";
        $this->species = "";
        $this->birthdate = "";
        $this->color = "";
        $this->length = "";
        $this->height = "";
        $this->weight = "";
        $this->name = "";
        $this->sex = "";
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

    private function validatePolicyId()
    {
        // Username should only contain letters, numbers, dashes and underscore
        $this->policyId = $this->extractForm('policyId');
    }

    private function validateBreed()
    {
        // Username should only contain letters, numbers, dashes and underscore
        $this->breed = $this->extractForm('breed');
    }

    private function validateSpecies()
    {
        $this->active = $this->extractForm('species');
    }

    private function validateBirthdate()
    {
        $this->birthdate = $this->extractForm('birthdate');
    }

    private function validateColor()
    {
        $this->color = $this->extractForm('color');
    }

    private function validateLength()
    {
        $this->length = $this->extractForm('length');
    }

    private function validateHeight()
    {
        $this->height = $this->extractForm('height');
    }

    private function validateWeight()
    {
        $this->Weight = $this->extractForm('Weight');
    }

    private function validateName()
    {
        $this->name = $this->extractForm('name');
    }

    private function validateSex()
    {
        $this->sex = $this->extractForm('sex');
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

    public function setPetId($id)
    {
        // Set the value of the userId to $id
        $this->petId = $id;
    }

    public function getPolicyId()
    {
        return $this->policyId;
    }

    public function getBreed()
    {
        return $this->breed;
    }

    public function getSpecies()
    {
        return $this->species;
    }

    public function getBirthdate()
    {
        return $this->birthdate;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSex()
    {
        return $this->sex;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function getParameters()
    {
        // Return data fields as an associative array
        $paramArray = array("petId" => $this->petId,
            "policyId" => $this->policyId,
            "breed" => $this->breed,
            "species" => $this->species,
            "birthdate" => $this->birthdate,
            "color" => $this->color,
            "length" => $this->length,
            "height" => $this->height,
            "weight" => $this->weight,
            "name" => $this->name,
            "sex" => $this->sex,
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

    public function __toString()
    {
        $str = "petId" . $this->petId .
            "policyId" . $this->policyId .
            "breed" . $this->breed .
            "species" . $this->species .
            "birthdate" . $this->birthdate .
            "color" . $this->color .
            "length" . $this->length .
            "height" . $this->height .
            "weight" . $this->weight .
            "name" . $this->name .
            "sex" . $this->sex .
            "active" . $this->active;
        return $str;
    }
}

?>