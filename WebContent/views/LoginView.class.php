<?php
class LoginView {
	public static function show() {
		$_SESSION ['headertitle'] = "Login Form";
		MasterView::showHeader ();
		MasterView::showNavBar ();
		LoginView::showDetails ();
	}
	public static function showDetails() {
        $user = (array_key_exists('user', $_SESSION)) ? $_SESSION['user'] : null;
        $base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
        echo '<section class ="text-center">';
		echo '<h2>Please Sign in</h2>';
		echo '<form action="login" method="Post">';
		echo '<p>User Name<br><input type="text" name="userName"';
		if (! is_null ( $user )) {
			echo 'value = "' . $user->getUserName () . '"';
		}
		echo '><br> <span class="error">';
		if (! is_null ( $user )) {
			echo $user->getError ( 'userName' );
		}
		echo '<br> </span> Password<br> <input type="password" name="password"';
		if (! is_null ( $user )) {
			echo 'value= "' . $user->getPassword () . '"';
		}
		echo '><br> <span class="error">';
		if (! is_null ( $user )) {
			echo $user->getError ( 'password' );
		}
		echo '</span><br> <input type="submit" name="submit" Value="submit"> </p> </form>';
		echo '</section>';
	}
}

?>