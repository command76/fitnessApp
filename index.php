<!DOCTYPE html>
<?php
require dirname(__FILE__, 1) . "/components/forms/post_workouts.php";
require dirname(__FILE__, 1) . "/components/forms/register.php";

// require dirname(__FILE__, 1) . "/controllers/users/user.php";

// require dirname(__FILE__, 1) . "/sections/user/user_contents.php";
?>

<?php registration_form(); ?>
<?php // isEnabled();

post_latest_workouts_form(); //display_user_stuff(); ?>
