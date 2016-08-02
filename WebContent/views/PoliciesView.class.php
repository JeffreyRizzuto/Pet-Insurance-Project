<?php

class PoliciesView
{

    public static function show()
    {
        $_SESSION['headertitle'] = "Profile View";
        MasterView::showHeader();
        MasterView::showNavBar();
        PoliciesView::showDetails();
    }

    public static function showDetails()
    {
        $user = (array_key_exists('user', $_SESSION)) ? $_SESSION['user'] : null;
        $base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
        $policies = (array_key_exists('policies', $_SESSION)) ? $_SESSION['policies'] : "";
    	echo '<div class="table-responsive">';
    	echo '<table class="table table-hover">';
    	echo "<thead>";
    	echo "<tr><th> totalAmount </th><th> startDate </th><th> endDate </th><th>Payment Option </th><th> active </th></tr>";
    	echo "</thead>";
    	echo "<tbody>";
    	foreach($policies as $policy){
    		echo '<tr>';
    		echo '<td>'.$policy->getTotalAmount() . '</td>';
    		echo '<td>'.$policy->getStartDate() . '</td>';
    		echo '<td>'.$policy->getEndDate()  . '</td>';
    		if($policy->getPaymentOption() == 6)
    			echo '<td>Monthly</td>';
    		else 
    			echo '<td>One Time Payment</td>';
    		if($policy->getActive() == 0)
    			echo '<td>No</td>';
    		else
    			echo '<td>Yes</td>';
    		echo '</tr>';
    	}
    	echo "</tbody>";
    	echo "</table>";
  		echo "</div>";
        echo '</section>';
    }
}