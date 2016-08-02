<?php

class DashboardView
{
    public static function show()
    {
        $_SESSION['headertitle'] = "Dashboard";
        MasterView::showHeader();
        MasterView::showNavBar();
        DashboardView::showDetails();
        $_SESSION['footertitle'] = "<h3></h3>";
        MasterView::showFooter();
    }

    public static function showDetails()
    {
        $user = (array_key_exists('user', $_SESSION)) ? $_SESSION['user'] : null;
        $base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
        echo '<section class ="text-center">';
    	echo '<div class="container-fluid">';
        echo '<ul class="nav nav-sidebar">';
       	echo '<li><a href="/' . $base . '/user/show/'.$user->getUserId().'">Profile</a></li>';
       	echo '<li><a href="/' . $base . '/address/show/'.$user->getUserId().'">User Addresses</a></li>';
        echo '<li><a href="/' . $base .'/policy/show/'.$user->getUserId().'">Policies</a></li>';
        echo '<li><a href="/' . $base . '/bill/current/'.$user->getPolicyId().'">Bill</a></li>';
        echo '</ul>';
        echo '</div>';
        echo '</section>';



    }


}