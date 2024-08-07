<?php

function login()
{
  echo "<form action='/' method='get'>";
  echo "<fieldset>";
  echo "<legend>Login</legend>";
  echo "<div>";
  echo "<label>Username</label>";
  echo "<input type='text' placeholder='Enter username' name='username' id='username' />";
  echo "</div>";
  echo "<div>";
  echo "<label>Password</label>";
  echo "<input type='text' placeholder='Enter password' name='username' id='username' />";
  echo "</div>";
  echo "<div>";
  echo "<input type='submit' value='submit' />";
  echo "</div>";
  echo "</fieldset>";
  echo "</form>";
}

?>
