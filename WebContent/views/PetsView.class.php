<?php

class PetsView
{

    public static function show()
    {
        $_SESSION['headertitle'] = "Signup Form";
        MasterView::showHeader();
        SignupView::showDetails();
    }

    public static function showNew()
    {

        $user = (array_key_exists('user', $_SESSION)) ? $_SESSION['user'] : null;
        $base = (array_key_exists('base', $_SESSION)) ? $_SESSION['base'] : "";
        echo '<h1>Pet</h1>';
        echo '<form method="post" action="/' . $base . '/pet/new/">';
        echo '<select name = "species">';
        echo '<option value="cat">cat</option>';
        echo '<option value="dog">dog</option>';
        echo '</select>';
        echo '<br>Breed<br>';
        echo '<input type="text" name="breed"><br>';
        echo '<br>Birth Date<br>';
        echo '<input type="text" name="birthdate"><br>';
        echo 'Color<br>';
        echo '<input type="text" name="color"><br>';
        echo 'Length<br>';
        echo '<input type="text" name="length"><br>';
        echo 'Height<br>';
        echo '<input type="text" name="height"><br>';
        echo 'Weight<br>';
        echo '<input type="text" name="weight"><br>';
        echo 'name<br>';
        echo '<input type="text" name="name"><br>';
        echo 'Gender:<input type="radio"';
        echo 'value ="male" name="sex"> Male';
        echo '<input type="radio"';
        echo 'value="female" name="sex"> Female';
        echo '<input type="hidden" name="active" value = "1">';
        echo '<br>';
        echo '<input type="submit" value="Submit"> </form>';
    }
    
    public static function show(){
 
    }
}

?>