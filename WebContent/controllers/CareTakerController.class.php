<?php

class CareTakerController
{

    public static function run()
    {
        // Perform actions related to a care taker
        $action = $_SESSION['action'];
        $arguments = $_SESSION['arguments'];
        switch ($action) {
            case "new":
                self::newCareTaker();
                break;
            case "show":
                $careTakers = CareTakersDB::getCareTakersBy('petId', $arguments);
                $_SESSION['bill'] = (!empty($careTakers)) ? $careTakers[0] : null;
                CareTakerView::show();
                break;
            case  "showall":
                $_SESSION['careTakers'] = CareTakersDB::getCareTakersBy();
                CareTakerView::showall();
                break;
            default:
        }
    }


    public static function newCareTaker()
    {
        // Process a new bill
        $careTaker = null;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $careTaker = new CareTaker($_POST);
            $careTaker = CareTakersDB::addCareTaker($careTaker);
        }
        if (is_null($careTaker) || $careTaker->getErrorCount() != 0) {
            $_SESSION['careTaker'] = $careTaker;
            CareTakerView::showNew();
        } else {
            HomeView::show();
            header('Location: /' . $_SESSION['base']);
        }
    }

}

?><?php
