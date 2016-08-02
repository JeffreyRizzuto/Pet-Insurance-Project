<?php
class HomeView {
	public static function show() {
		$_SESSION ['headertitle'] = "Home Page";
		MasterView::showHeader ();
		MasterView::showNavBar ();
		HomeView::showDetails ();
		$_SESSION ['footertitle'] = "<h3></h3>";
		MasterView::showFooter ();
	}
	public static function showDetails() {
   		$user = (array_key_exists('user', $_SESSION))?$_SESSION['user']:null;
   		$base = $_SESSION['base'];
		
		echo "
	   	<!-- Page Content -->
    <div class='container'>

        <hr class='featurette-divider'>

        <!-- First Featurette -->
        <div class='featurette' id='about'>
            <img class='featurette-image img img-responsive pull-right' src='https://c1.staticflickr.com/9/8607/16255176652_25206fd64f_b.jpg'>
            <h2 class='featurette-heading'>We know you love your pet
                <span class='text-muted'>, and we do too</span>
            </h2>
            <p class='lead'>With Pet Insurance, you can give your pet the best medical care possible. Our pet insurance plans cover everything to keep your pet healty and happy.</p>
        </div>

        <hr class='featurette-divider'>

        <!-- Second Featurette -->
        <div class='featurette' id='services'>
            <img class='featurette-image img-circle img-responsive pull-left' src='https://upload.wikimedia.org/wikipedia/commons/1/1c/Smiling_Dog_Face.jpg'>
            <h2 class='featurette-heading'>Keep your pet safe
                <span class='text-muted'>with affordable policies for any kind of budget</span>
            </h2>
            <p class='lead'></p>
        </div>

        <hr class='featurette-divider'>

        <!-- Third Featurette -->
        <div class='featurette' id='contact'>
            <img class='featurette-image img-circle img-responsive pull-right' src='https://farm9.static.flickr.com/8008/7537056436_484dcb5a08.jpg'>
            <h2 class='featurette-heading'>\"Company of the year 2015\"
                <span class='text-muted'>~Time Magazine</span>
            </h2>
            <p class='lead'></p>
        </div>

        <hr class='featurette-divider'>
    </div>
    <!-- /.container -->
    ";
	}
}

?>