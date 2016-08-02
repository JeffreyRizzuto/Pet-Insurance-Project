<?php

class BillView
{

    public static function showCurrent()
    {
    	$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
    	MasterView::showHeader();
    	MasterView::showNavBar();
		$bills = $_SESSION['bill'];
		$bill = $bills[0];
		echo '<section class ="text-center">';
		echo $bill['billId'];
		echo '<p><strong>Due Date</strong></p>';
		echo $bill['dueDate'];
		echo '<p><strong>Balance</strong></p>';
		echo $bill['balance'];
		echo '<p><strong>Minimum Payment</strong></p>';
		echo $bill['minimumPayment']. '<br>';
		
		echo '<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Pay Bill</button>';
		echo '<div id="demo" class="collapse out">';
		echo '<form action = "/'.$base.'/bill/pay/" method="Post" role="form">';
		echo '<input type ="hidden" name="billId" value = "'.$bill['billId'].'">';
		echo '<div class="form-inline">';
		echo  '<label for="name">Name</label><br>'; 
		echo '<input type="text" name="firstName" class="form-control" placeholder="First Name"><input type="text" name="lastName" class="form-control" placeholder="Last Name"><br>';
		echo '</div>';
		echo '<div class="form-inline">';
		echo '<select name = "debitOrCredit"  class="form-control">';
		echo '<option value="Credit">Credit</option>';
		echo '<option value="Debit">Debit</option>';
		echo'</select>';
		echo '<select name = "cardType"  class="form-control">';
		echo '<option value="MasterCard">Mastercard</option>';
		echo '<option value="Visa">Visa</option>';
		echo'</select>';
		echo '</div>';
		echo '<div class="form-inline">';
		echo '<label for="cardNumber">Card Number</label><br>';
		echo '<input type="text" name="cardNumber" class="form-control">';
		echo '</div>';
		echo '<div class="form-inline">';
		echo '<label for="zipcode">zipcode</label><br>';
		echo '<input type="text" name="zipcode"  class="form-control">';
		echo '</div>';
		echo '<div class="form-inline">';
		echo '<label for="expirationDate">Expiration Date</label><br>';
		echo '<input type="text" name="expirationDate"  class="form-control">';
		echo '</div>';
		echo'<input type="submit" value="Submit"> </form>';
		echo '</section>';
	
    }
}