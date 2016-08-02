<?php

class UserAddressView
{

    public static function show()
    {
        $_SESSION['headertitle'] = "Signup Form";
        MasterView::showHeader();
        MasterView::showNavBar();
        UserAddressView::showDetails();
    }

    public static function showNew()
    {
    	MasterView::showHeader();
    	MasterView::showNavBar();
        $user = (array_key_exists('user', $_SESSION)) ? $_SESSION['user'] : null;
        $base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
        echo '<section class ="text-center">';
        echo '<h1>Address</h1>';
        echo '<form method="post" action="/' . $base . '/address/new/">';
        echo 'address<br>';
        echo '<input type="text" name="address"><br>';
        echo '<select name = "state">';
        echo '<option value="AL">Alabama</option>';
        echo '<option value="AK">Alaska</option>';
        echo '<option value="AZ">Arizona</option>';
        echo '<option value="AR">Arkansas</option>';
        echo '<option value="CA">California</option>';
        echo '<option value="CO">Colorado</option>';
        echo '<option value="CT">Connecticut</option>';
        echo '<option value="DE">Delaware</option>';
        echo '<option value="DC">District Of Columbia</option>';
        echo '<option value="FL">Florida</option>';
        echo '<option value="GA">Georgia</option>';
        echo '<option value="HI">Hawaii</option>';
        echo '<option value="ID">Idaho</option>';
        echo '<option value="IL">Illinois</option>';
        echo '<option value="IN">Indiana</option>';
        echo '<option value="IA">Iowa</option>';
        echo '<option value="KS">Kansas</option>';
        echo '<option value="KY">Kentucky</option>';
        echo '<option value="LA">Louisiana</option>';
        echo '<option value="ME">Maine</option>';
        echo '<option value="MD">Maryland</option>';
        echo '<option value="MA">Massachusetts</option>';
        echo '<option value="MI">Michigan</option>';
        echo '<option value="MN">Minnesota</option>';
        echo '<option value="MS">Mississippi</option>';
        echo '<option value="MO">Missouri</option>';
        echo '<option value="MT">Montana</option>';
        echo '<option value="NE">Nebraska</option>';
        echo '<option value="NV">Nevada</option>';
        echo '<option value="NH">New Hampshire</option>';
        echo '<option value="NJ">New Jersey</option>';
        echo '<option value="NM">New Mexico</option>';
        echo '<option value="NY">New York</option>';
        echo '<option value="NC">North Carolina</option>';
        echo '<option value="ND">North Dakota</option>';
        echo '<option value="OH">Ohio</option>';
        echo '<option value="OK">Oklahoma</option>';
        echo '<option value="OR">Oregon</option>';
        echo '<option value="PA">Pennsylvania</option>';
        echo '<option value="RI">Rhode Island</option>';
        echo '<option value="SC">South Carolina</option>';
        echo '<option value="SD">South Dakota</option>';
        echo '<option value="TN">Tennessee</option>';
        echo '<option value="TX">Texas</option>';
        echo '<option value="UT">Utah</option>';
        echo '<option value="VT">Vermont</option>';
        echo '<option value="VA">Virginia</option>';
        echo '<option value="WA">Washington</option>';
        echo '<option value="WV">West Virginia</option>';
        echo '<option value="WI">Wisconsin</option>';
        echo '<option value="WY">Wyoming</option>';
        echo '</select>';
        echo '<br>Zipcode<br>';
        echo '<input type="text" name="zipcode"><br>';
        echo 'City<br>';
        echo '<input type="text" name="city"><br>';
        echo 'Is this the Pet address:<input type="radio" value ="1" name="isPetAddress"> Yes';
        echo '<input type="radio" value="0" name="isPetAddress"> No';
        echo '<input type="hidden" name="userId" value = "' . $user->getUserId() . '">';
        echo '<br>';
        echo '<input type="submit" value="Submit"> </form>';
        echo '</section>';
    }
    
    public static function showDetails(){
    	$user = (array_key_exists('user', $_SESSION)) ? $_SESSION['user'] : null;
    	$base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
    	$userAddresses = (array_key_exists('userAddresses', $_SESSION)) ? $_SESSION['userAddresses'] : "";
    	echo '<div class="table-responsive">';
    	echo '<table class="table table-hover">';
    	echo "<thead>";
    	echo "<tr><th> address </th><th> city </th><th> State </th><th> Zipcode </th><th> Pet Address </th></tr>";
    	echo "</thead>";
    	echo "<tbody>";
    	foreach($userAddresses as $userAddress){
    		echo '<tr>';
    		echo '<td>'.$userAddress->getAddress() . '</td>';
    		echo '<td>'.$userAddress->getCity() . '</td>';
    		echo '<td>'.$userAddress->getState()  . '</td>';
    		echo '<td>'.$userAddress->getZipcode()  . '</td>';
    		if($userAddress->getIsPetAddress() == 0)
    			echo '<td>No</td>';
    		else
    			echo '<td>Yes</td>';
    		echo '</tr>';
    	}
    	echo "</tbody>";
    	echo "</table>";
  		echo "</div>";
    }
}

?>