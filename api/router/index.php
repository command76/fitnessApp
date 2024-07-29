<?php
// Require composer autoloader
require dirname(__FILE__, 3) . "/vendor/autoload.php";
// require dirname(__FILE__, 3) . "/connection.php";
require dirname(__FILE__, 2) . "/plant_seeds.php";

// Create Router instance
$router = new \Bramus\Router\Router();
$router->get("/random_users/", function () {
  $number = $_GET["amount"];
  return preg_match("/\d{0,9}/", $number)
    ? get_random_users($number)
    : "<p>Something went wrong</p>";
});
$router->get("/predefined_user/", function () {
    $fname = $_GET["fname"];
    $lname = $_GET["lname"];
    if (
        preg_match("/[A-Za-z]*/", $fname) &&
        preg_match("/[A-Za-z]*/", $lname)
      ) {
        get_predefined_user($fname, $lname);
      } else {
        echo "<p>Something went wrong</p>";
      }
});

// Define routes
// ...

// Run it!
$router->run();

?>
