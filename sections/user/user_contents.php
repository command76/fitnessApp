<?php
require dirname(__FILE__, 3) . "/forms/register.php";
require dirname(__FILE__, 3) . "/forms/post_workouts.php";
function is_enabled($is_enabled)
{
  if ($is_enabled) {
    echo "TRUEEEE";
  } else {
    echo "FALSLSE";
  }
}

function display_user_stuff()
{
  //   if () {
  //     echo "is enabled";
  //   } else {
  //     echo "NOOOOO!";
  //   }
  //     return post_latest_workouts_form();
  // } else {
  //   registration_form();
  //   echo "Please login or create an account";
  //   return;
}

?>
