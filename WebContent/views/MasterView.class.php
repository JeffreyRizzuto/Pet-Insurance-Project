<?php
if (! isset ( $_SESSION )) {
	session_start ();
} // start session if not already
class MasterView {
	public static function showHeader() {
		echo "<!DOCTYPE html><html><head>";
		$title = (array_key_exists ( 'headertitle', $_SESSION )) ? $_SESSION ['headertitle'] : "";
		echo "<title>$title</title>";
		echo " <!-- Latest compiled and minified CSS -->
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css' integrity='sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==' crossorigin='anonymous'>

<!-- Optional theme -->
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css' integrity='sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX' crossorigin='anonymous'>
<link rel='stylesheet' href='https://ironsummitmedia.github.io/startbootstrap-one-page-wonder/css/one-page-wonder.css'>
<!-- Latest compiled and minified JavaScript -->
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js' integrity='sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==' crossorigin='anonymous'></script>
";
		echo "</head><body>";
		
		echo '<!DOCTYPE html lang="en"><html><head>';
		echo '<meta charset="utf-8">';
		echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
		echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
		echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">';
		echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">';
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>';
		echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>';
		echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">';
		echo '<link rel="stylesheet" href="https://ironsummitmedia.github.io/startbootstrap-one-page-wonder/css/one-page-wonder.css">';
		
		$styles = (array_key_exists('styles', $_SESSION))? $_SESSION['styles']: array();
		$base = (array_key_exists('base', $_SESSION))? $_SESSION['base']: "";
		foreach ($styles as $style )
			echo '<link href="/'.$base.'/css/'.$style. '" rel="stylesheet">';
		$title = (array_key_exists('headertitle', $_SESSION))? $_SESSION['headertitle']: "";
		echo "<title>$title</title>";
	}
	public static function showNavBar() {
		// Show the navbar
        $user = (array_key_exists('user', $_SESSION)) ? $_SESSION['user'] : null;
        $authenticatedUser = (array_key_exists('authenticatedUser', $_SESSION))?$_SESSION['authenticatedUser']:null;
        $base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
		// $user = (array_key_exists('user', $_SESSION)) ? $_SESSION['user'] : null;
		echo "
		<!-- Static navbar -->
      <nav class='navbar navbar-inverse'>
        <div class='container-fluid'>
          <div class='navbar-header'>
            <button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#navbar' aria-expanded='false' aria-controls='navbar'>
              <span class='sr-only'>Toggle navigation</span>
            </button>
            <a class='navbar-brand' href='";
		echo '/' . $_SESSION ['base'] . '/';
		echo "home'>JDJ</a>
          </div>
          <div id='navbar' class='navbar-collapse collapse'>
            <ul class='nav navbar-nav'>
              <li><a href='";
		echo '/' . $_SESSION ['base'] . '/';
		echo "home'>Home</a></li>
            </ul>
            <ul class='nav navbar-nav navbar-right'>
            ";
		if (is_null ( $authenticatedUser )) {
			echo "
			<li><a href='";
			echo '/' . $_SESSION ['base'] . '/';
			echo "signup'>Sign Up</a></li>
			<li><a href='";
			echo '/' . $_SESSION ['base'] . '/';
			echo "login'>Login</a></li>
			";
		} else {
			echo '<li><a href="/'.$base.'/dashboard/show/'.$authenticatedUser->getUserId().'">Dashboard</a></li>';
			echo "<li><a href='";
			echo '/' . $_SESSION ['base'] . '/';
			echo "logout'>Logout</a></li>
            ";
		}
		echo "
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
		";
		/* if(!is_null($user)){
			echo "Welcome ". $user->getFirstName()."<br>";
		} */
		
		echo "</nav>";
	}
	public static function showFooter() {
		$footer = (array_key_exists ( 'footertitle', $_SESSION )) ? $_SESSION ['footertitle'] : "";
		echo $footer;
		echo "
		<!-- Footer -->
        <footer>
            <div class='row'>
                <div class='col-lg-12'>
                    <p>Copyright &copy; JDJ Pet Insurance 2015</p>
                </div>
            </div>
        </footer>
		";
		echo "</body></html>";
	}
}

?>