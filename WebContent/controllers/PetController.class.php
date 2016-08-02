<?php

class PetController
{

    public static function run()
    {
        // Perform actions related to a pet
        $action = $_SESSION['action'];
        $arguments = $_SESSION['arguments'];
        switch ($action) {
            case "new":
                self::newPet();
                break;
            case "show":
                $pets = PetsDB::getPetsBy('petId', $arguments);
                $_SESSION['pets'] = $pets;
                PetsView::show();
                break;
            case  "showall":
                $_SESSION['pets'] = PetsDB::getPetsBy();
                PetsView::showall();
                break;
            default:
        }
    }


    public static function newPet()
    {
        // Process a new pet
        $pet = null;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $pet = new Pets($_POST);
            $pet = PetsDB::addPet($pet);
        }
        if (is_null($pet) || $pet->getErrorCount() != 0) {
            $_SESSION['pet'] = $pet;
            PetsView::showNew();
        } else {
            HomeView::show();
            header('Location: /' . $_SESSION['base']);
        }
    }
    
    public static function show(){
    	PetsView::show();
    }

}

?>

