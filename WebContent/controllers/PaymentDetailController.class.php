<?php

class PaymentDetailController
{

    public static function run()
    {
        // Perform actions related to a payment detail
        $action = $_SESSION['action'];
        $arguments = $_SESSION['arguments'];
        switch ($action) {
            case "new":
                self::newPaymentDetail();
                break;
            case "show":
                $paymentDetails = PaymentDetailsDB::getPaymentDetailsBy('paymentDetailsId', $arguments);
                $_SESSION['paymentDetail'] = (!empty($paymentDetails)) ? $paymentDetails[0] : null;
                PaymentDetailView::show();
                break;
            case  "showall":
                $_SESSION['paymentDetails'] = PaymentDetailsDB::getPaymentDetailsBy();
                PaymentDetailView::showall();
                break;
            default:
        }
    }


    public static function newPaymentDetail()
    {
        // Process a new payment detail
        $paymentDetail = null;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $paymentDetail = new PaymentDetail($_POST);
            $paymentDetail = PaymentDetailsDB::addPaymentDetail($paymentDetail);
        }
        if (is_null($paymentDetail) || $paymentDetail->getErrorCount() != 0) {
            $_SESSION['paymentDetail'] = $paymentDetail;
            PaymentDetailView::showNew();
        } else {
            HomeView::show();
            header('Location: /' . $_SESSION['base']);
        }
    }

}

?><?php
