<?php

class BillController
{

    public static function run()
    {
        // Perform actions related to a bill
        $action = $_SESSION['action'];
        $arguments = $_SESSION['arguments'];
        switch ($action) {
            case "new":
                self::newBill();
                break;
            case "show":
                $bills = BillsDB::getBillsBy('billId', $arguments);
                $_SESSION['bill'] = (!empty($bills)) ? $bills[0] : null;
                BillView::show();
                break;
            case "current":
            	$bill = BillsDB::getCurrent($arguments);
            	$_SESSION['bill'] = $bill;
            	BillView::showCurrent();
            	break;
            case  "showall":
                $_SESSION['bills'] = BillsDB::getBillsBy();
                BillView::showall();
                break;
            case "pay":
            	$paymentDetails = new PaymentDetails($_POST);
            	$paymentdetail = PaymentDetailsDB::addPaymentDetail($paymentDetails);
            	HomeView::show();
            default:
        }
    }


    public static function newBill()
    {
        // Process a new bill
        $bill = null;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $bill = new Bill($_POST);
            $bill = BillsDB::addBill($bill);
        }
        if (is_null($bill) || $bill->getErrorCount() != 0) {
            $_SESSION['bill'] = $bill;
            BillView::showNew();
        } else {
            HomeView::show();
            header('Location: /' . $_SESSION['base']);
        }
    }

}

?><?php
