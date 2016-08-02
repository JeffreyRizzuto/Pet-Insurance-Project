<?php

class UserView
{

    public static function show()
    {
        $_SESSION['headertitle'] = "Profile View";
        MasterView::showHeader();
        MasterView::showNavBar();
        UserView::showDetails();
    }

    public static function showDetails()
    {
        $user = (array_key_exists('user', $_SESSION)) ? $_SESSION['user'] : null;
        $base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
        echo '<section class ="text-center">';
        echo '<h1>Your Profile</h1>';
        echo '</p> <p>Name: ';
        if (!is_null($user)) {
            echo($user->getFirstName() . " " . $user->getLastName());
        }
        echo '<p>User Name: ';
        if (!is_null($user)) {
            echo $user->getUserName();
        }
        echo '<p>Sex: ';
        if (!is_null($user)) {
            echo $user->getGender();
        }
        echo '</p> <p>Birthday: ';
        if (!is_null($user)) {
            echo $user->getBirthday();
        }
        echo '</p> <p>Email:';
        if (!is_null($user)) {
            echo $user->getEmail();
        }
        echo '</p> <P>Phone Number:';
        if (!is_null($user)) {
            echo $user->getPhoneNumber();
        }
        echo '</p>';
        echo '<a href="/' . $base . '/user/update/' . $user->getUserId() . '"> Edit Profile</a>';
        echo '</section>';
    }

    public static function showUpdate()
    {
    	MasterView::showHeader();
    	MasterView::showNavBar();
        $users = (array_key_exists('users', $_SESSION)) ? $_SESSION['users'] : null;
        $base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";

        $_SESSION['headertitle'] = "Update Profile";
        MasterView::showHeader();
        if (is_null($users) || empty($users) || is_null($users[0])) {
            echo '<section>User does not exist</section>';
            return;
        }
        $user = $users[0];
		
        echo '<section class ="text-center">';
        echo '<h1>Your Profile</h1>';
        echo '</p> <p>Name: ';
        if (!is_null($user)) {
            echo($user->getFirstName() . " " . $user->getLastName());
        }
        echo '<p>Sex: ';
        if (!is_null($user)) {
            echo $user->getGender();
        }
        echo '</p> <p>Birthday: ';
        if (!is_null($user)) {
            echo $user->getBirthday();
        }

        if ($user->getErrors() > 0) {
            $errors = $user->getErrors();
            echo '<section><p>Errors:<br>';
            foreach ($errors as $key => $value)
                echo $value . "<br>";
            echo '</p></section>';
        }

        echo '<form method="post" action="/' . $base . '/user/update/' .
            $user->getUserId() . '">';
        echo 'User Name<br>';
        echo '<input type="text" name="userName"';
        if (!is_null($user)) {
            echo 'value = "' . $user->getUserName() . '"';
        }
        echo '> <span class="error">';
        if (!is_null($user)) {
            echo $user->getError('userName');
        }
        echo '</span> <br>';
        echo 'Email<br>';
        echo '<input type="email" name="email"';
        echo 'value = "' . $user->getEmail() . '"><br>';
        echo 'Phone Number (xxx-xxx-xxxx)<br>';
        echo '<input type="tel" name="phoneNumber"';
        echo 'value = "' . $user->getPhoneNumber() . '"><br>';
        echo '<input type="submit" value="Submit"> </form>';
        echo '</section>';
    }
}