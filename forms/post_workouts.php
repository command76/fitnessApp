<?php
require dirname(__FILE__, 2) . "/api/form_insert_type_queries.php";
function post_latest_workouts_form()
{
  echo "<form action='/api/router/post_latest_workouts' method='post'>";
  echo "<fieldset>";
  echo "<legend>Post Latest Workouts</legend>";
  echo "<div>";
  echo "<label>Push Ups</label>";
  echo '<input id="push_ups" name="push_ups" type="number" value="Enter number" placeholder="Enter number between 1 and 99"/>';
  echo "</div>";
  echo "<div>";
  echo "<label>Sit Ups</label>";
  echo '<input id="sit_ups" name="sit_ups" type="number" value="Enter number" placeholder="Enter number between 1 and 99"/>';
  echo "</div>";
  echo "<div>";
  echo "<label>Dips</label>";
  echo '<input id="dips" name="dips" type="number" value="Enter number" placeholder="Enter number between 1 and 99"/>';
  echo "</div>";
  echo "<div>";
  echo "<label>Running</label>";
  echo '<input id="running" name="running" type="number" value="Enter number" placeholder="Enter number between 1 and 99"/>';
  echo "</div>";
  echo "<div>";
  echo "<label>Jumping Jacks</label>";
  echo '<input id="jumping_jacks" name="jumping_jacks" type="number" value="Enter number" placeholder="Enter number between 1 and 99"/>';
  echo "</div>";
  echo "<div>";
  echo "<label>Burpees</label>";
  echo '<input id="burpees" name="burpees" type="number" value="Enter number" placeholder="Enter number between 1 and 99"/>';
  echo "</div>";
  echo "<div>";
  echo '<input type="submit" value="submit" />';
  echo "</div>";
  echo "</fieldset>";
  echo "</form>";
}

?>
