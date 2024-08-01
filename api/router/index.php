<?php
// Require composer autoloader
require dirname(__FILE__, 3) . "/vendor/autoload.php";
require dirname(__FILE__, 3) . "/connection.php";
use dbconnecting as DB;
require dirname(__FILE__, 2) . "/plant_seeds.php";
require dirname(__FILE__, 2) . "/remove_seeds.php";
require dirname(__FILE__, 3) . "/index.php";

// Create Router instance
$router = new \Bramus\Router\Router();

// Define routes
$router->post("/random_users/", function () {
  $connectionObject = new DB\connection();
  $number = $_GET["amount"];
  return preg_match("/\d{0,9}/", $number)
    ? get_random_users($number, $connectionObject)
    : "<p>Something went wrong</p>";
});
$router->post("/predefined_user/", function () {
  $fname = $_GET["fname"];
  $lname = $_GET["lname"];
  $connectionObject = new DB\connection();
  if (preg_match("/[A-Za-z]*/", $fname) && preg_match("/[A-Za-z]*/", $lname)) {
    get_predefined_user($fname, $lname, $connectionObject);
  } else {
    echo "<p>Something went wrong</p>";
  }
});
$router->options("/delete_recent_users/", function () {
  $connectionObject = new DB\connection();
  header("Host: localhost");
  header("Accept: text/html");
  header("Accept-Language: en-us,en;q=0.5");
  header("Accept-Encoding: gzip,deflate");
  header("Connection: keep-alive");
  header("Origin: https://localhost:8888");
  header("Access-Control-Request-Method: DELETE");
  header("Access-Control-Request-Headers: content-type,x-pingother");
  $number = $_GET["amount"];
  return preg_match("/\d{0,9}/", $number)
    ? delete_recent_users($number, $connectionObject)
    : "<p>Something went wrong</p>";
});
$router->delete("/delete_users_by_name/", function () {
  $connectionObject = new DB\connection();
  $errors = [];
  try {
    if (!isset($_GET["amount"])) {
      $number = 1;
    } elseif (preg_match("/\d\S{0,9}/", $_GET["amount"])) {
      $number = $_GET["amount"];
    } else {
      // Maybe use Error too
      throw new Exception("Please enter a valid number");
    }
  } catch (Exception $e) {
    array_push($errors, $e->getMessage());
  }
  try {
    if (!isset($_GET["first_name"])) {
      throw new Exception("Please enter a first name");
    } elseif (preg_match("/[A-Za-z]+/", $_GET["first_name"])) {
      $fname = $_GET["first_name"];
    } else {
      throw new Exception("Enter a valid name");
    }
  } catch (Exception $e) {
    array_push($errors, $e->getMessage());
  }
  try {
    if (!isset($_GET["last_name"])) {
      throw new Exception("Please enter a last name");
    } elseif (preg_match("/[A-Za-z]+/", $_GET["last_name"])) {
      $lname = $_GET["last_name"];
    } else {
      throw new Exception("Enter a valid name");
    }
  } catch (Exception $e) {
    array_push($errors, $e->getMessage());
  }
  return count($errors) > 0
    ? print_r($errors)
    : delete_users_by_name(
      $name = [$fname, $lname],
      $number,
      $connectionObject
    );
});
$router->post("/post_latest_workouts/", function () {
  $connectionObject = new DB\connection();
  $workouts = [
    "pushups" => $_POST["push_ups"],
    "situps" => $_POST["sit_ups"],
    "dips" => $_POST["dips"],
    "running" => $_POST["running"],
    "jumpingjacks" => $_POST["jumping_jacks"],
    "burpees" => $_POST["burpees"],
  ];

  return upsert_latest_user_workouts($workouts, $connectionObject);
});

// Run it!
$router->run();

?>
