<?php

function registration_form()
{
  echo "<form action='/api/router/register' method='post'>";
  echo "<fieldset>";
  echo "<legend>Register a new account</legend>";
  echo "<div>";
  echo "<label>First Name</label>";
  echo "<input type='text' name='first_name' id='first_name' value='first name' placeholder='enter first name'/>";
  echo "</div>";
  echo "<div>";
  echo "<label>Last Name</label>";
  echo "<input type='text' name='last_name' id='last_name' value='last name' placeholder='enter last name'/>";
  echo "</div>";
  echo "<div>";
  echo "<label>Email</label>";
  echo "<input type='email' name='email' id='email' value='email' placeholder='enter email'/>";
  echo "</div>";
  echo "<div>";
  echo "<label>Before Pic</label>";
  echo "<input type='text' name='before_pic' id='before_pic' value='Before Picture' placeholder='Upload pic of current physique'/>";
  echo "</div>";
  echo "<div>";
  echo "<label>Username</label>";
  echo "<input type='text' name='username' id='username' value='username' placeholder='enter a username'/>";
  echo "</div>";
  echo "<div>";
  echo "<label>Password</label>";
  echo "<input type='text' name='password' id='password' value='password' placeholder='enter a password'/>";
  echo "</div>";
  echo "<div>";
  echo "<input type='submit' value='submit' />";
  echo "</div>";
  echo "</fieldset>";
  echo "</form>";
}

?>
