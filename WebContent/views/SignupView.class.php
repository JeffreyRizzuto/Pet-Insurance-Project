<?php
class SignupView {
	public static function show() {
		$_SESSION ['headertitle'] = "Signup Form";
		MasterView::showHeader ();
		MasterView::showNavBar ();
		SignupView::showDetails ();
	}
	public static function showDetails() {
        $user = (array_key_exists('user', $_SESSION)) ? $_SESSION['user'] : null;
        $base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
        echo '<section class ="text-center">';
		echo '<h1>Sign Up</h1>';
		echo '<form action="signup" method="Post">';
		echo 'Name<br> <input type="text" name="firstName"';
		if (! is_null ( $user )) {
			echo 'value = "' . $user->getFirstName () . '"';
		}
		echo '>';
		echo '<input type="text" name="lastName"';
		if (! is_null ( $user )) {
			echo 'value = "' . $user->getLastName () . '"';
		}
		echo '> <span class="error">';
		if (! is_null ( $user )) {
			echo $user->getError ( 'firstName' );
		}
		echo '</span> <span class="error">';
		if (! is_null ( $user )) {
			echo $user->getError ( 'lastName' );
		}
		echo '<br> </span> <br>';
		echo 'User Name<br>';
		echo '<input type="text" name="userName"';
		if (! is_null ( $user )) {
			echo 'value = "' . $user->getUserName () . '"';
		}
		echo '> <span class="error">';
		if (! is_null ( $user )) {
			echo $user->getError ( 'userName' );
		}
		echo '<br> </span> <br>';
		echo 'Password<br>';
		echo '<input type="password" name="password"';
		if (! is_null ( $user )) {
			echo 'value = "' . $user->getPassword () . '"';
		}
		echo '> <span class="error">';
		if (! is_null ( $user )) {
			echo $user->getError ( 'password' );
		}
		echo '<br> </span> <br>';
		echo 'Ssn<br>';
		echo '<input type="password" name="ssn"';
		if (! is_null ( $user )) {
			echo 'value = "' . $user->getSsn () . '"';
		}
		echo '> <span class="error">';
		if (! is_null ( $user )) {
			echo $user->getError ( 'ssn' );
		}
		echo '<br> </span> <br>';
		echo 'Email<br>';
		echo '<input type="email" name="email"';
		if (! is_null ( $user )) {
			echo 'value = "' . $user->getEmail () . '"';
		}
		echo '> <span class="error">';
		if (! is_null ( $user )) {
			echo $user->getError ( 'email' );
		}
		echo '<br> </span> <br>';
		echo 'Phone Number (xxx-xxx-xxxx)<br>';
		echo '<input type="tel" name="phoneNumber"';
		if (! is_null ( $user )) {
			echo 'value = "' . $user->getPhoneNumber () . '"';
		}
		echo '> <span class="error">';
		if (! is_null ( $user )) {
			echo $user->getError ( 'phoneNumber' );
		}
		echo '<br> </span> <br>';
		
		echo 'Gender:<input type="radio"';
		if (! is_null ( $user ) && $user->getGender () == "male") {
			echo 'checked = ""';
		}
		echo 'value ="male" name="gender"> Male';
		echo '<input type="radio"';
		if (! is_null ( $user ) && $user->getGender () == "female") {
			echo 'checked = ""';
		}
		echo 'value="female" name="gender"> Female';
		echo '<span class="error">';
		if (! is_null ( $user )) {
			echo $user->getError ( 'gender' );
		}
		echo '<br> </span>';
		
		echo 'Birthday<br>';
		echo '<input type="text" name="birthday"';
		if (! is_null ( $user )) {
			echo 'value = "' . $user->getBirthday () . '"';
		}
		echo '> <br>';
		
		echo 'Primary Owner:<input type="radio"';
		if (! is_null ( $user ) && $user->getIsPrimaryPolicyHolder ()) {
			echo 'checked = ""';
		}
		echo 'value ="1" name="isPrimaryPolicyHolder"> Yes';
		echo '<input type="radio"';
		if (! is_null ( $user ) && ! $user->getIsPrimaryPolicyHolder ()) {
			echo 'checked = ""';
		}
		echo 'value="0" name="isPrimaryPolicyHolder"> No';
		echo '<span class="error">';
		if (! is_null ( $user )) {
			echo $user->getError ( 'gender' );
		}
		echo '<br> </span>';
		
		echo 'Relation With Primary Policy Holder<br>';
		echo '<select name="relationWithPrimaryPolicyHolder">';
		echo '<option value="None">None</option>';
		echo '<option value="Friend">Friend</option>';
		echo '<option value="Parent">Parent</option>';
		echo '<option value="Sibling">Sibling</option>';
		echo '<option value="Child">Child</option>';
		echo '</select>';
		
		echo '<input type ="hidden" name="active" value="1">';
		echo '<br>';
		echo '<input type="submit" value="Submit"> </form>';
		echo '</section>';
	}
}

?>