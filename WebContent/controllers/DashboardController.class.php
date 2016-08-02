<?php
class DashboardController {
	
	public static function run()
	{
		// Perform actions related to a user address
		$action = $_SESSION['action'];
		$arguments = $_SESSION['arguments'];
		switch ($action) {
			case "new":
				self::newUserAddress();
				break;
			case "show":
				$users = UsersDB::getUsersBy('userId', $arguments);
				$user = $users[0];
				$_SESSION['user'] = $user;
				self::show();
				break;
			case  "showall":
				break;
			case "update":
				self::updateUser();
				break;
			default:
		}
	}
	
	public static function show() {
		$user = null;
		$user = $_SESSION['user'];
		if (is_null ( $user )) { // no user or errors
			LoginView::show ();
			// HomeView::show();
		} else { // user is logged in
			DashboardView::show ();
			// header('Location: /' . $_SESSION['base']);
		}
	}
}