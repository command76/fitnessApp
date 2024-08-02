<?php
// Start doing front end stuff
// allow user to login

// Require composer autoloader
require dirname(__FILE__, 3) . "/vendor/autoload.php";
require dirname(__FILE__, 3) . "/connection.php";
use dbconnecting as DB;
require dirname(__FILE__, 2) . "/plant_seeds.php";
require dirname(__FILE__, 2) . "/remove_seeds.php";
ob_start();
require dirname(__FILE__, 3) . "/index.php";
ob_end_clean();

// Create Router instance
$router = new \Bramus\Router\Router();

// Define routes
$router->post("/random_users/", function () {
  $connectionObject = new DB\connection();
  if (isset($_GET["amount"])) {
    $number = $_GET["amount"];
  } else {
    print_r("Please add amount to url params");
    return;
  }
  if (!is_numeric($number)) {
    print_r("Please add numerical amount");
  } elseif (preg_match("/^\d{0,2}$/", $number) && $number != 0) {
    get_random_users($number, $connectionObject);
  } else {
    print_r("Enter amount between 1 and 99");
  }
});
$router->post("/predefined_user/", function () {
  if (isset($_GET["fname"])) {
    $fname = $_GET["fname"];
  } else {
    print_r("Add fname to url params with a first name");
    return;
  }
  if (isset($_GET["lname"])) {
    $lname = $_GET["lname"];
  } else {
    print_r("Add lname url params with last name");
    return;
  }
  $connectionObject = new DB\connection();
  if (preg_match("/[A-Za-z]+/", $fname) && preg_match("/[A-Za-z]+/", $lname)) {
    get_predefined_user($fname, $lname, $connectionObject);
  } else {
    print_r("Please add name to fname and/or lname params");
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
  if (isset($_GET["amount"])) {
    $number = $_GET["amount"];
  } else {
    print_r("Please add a amount to the url params");
    return;
  }
  if (!is_numeric($number)) {
    print_r("Please add a numerical amount");
  } elseif (preg_match("/^\d{0,2}$/", $number) && $number != 0) {
    delete_recent_users($number, $connectionObject);
  } else {
    print_r("Enter amount between 0 and 100");
  }
});
$router->delete("/delete_users_by_name/", function () {
  $connectionObject = new DB\connection();
  $errors = [];

  try {
    if (!isset($_GET["amount"])) {
      $number = 1;
    } elseif (is_numeric($_GET["amount"])) {
      preg_match("/^\d{0,2}$/", $_GET["amount"]) && $_GET["amount"] != 0
        ? ($number = $_GET["amount"])
        : throw new Exception("Please enter amount between 1 and 99");
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
    "push_ups" => $_POST["push_ups"],
    "sit_ups" => $_POST["sit_ups"],
    "dips" => $_POST["dips"],
    "running" => $_POST["running"],
    "jumping_jacks" => $_POST["jumping_jacks"],
    "burpees" => $_POST["burpees"],
  ];

  try {
    if (array_search(!null, $workouts)) {
      upsert_latest_user_workouts($workouts, $connectionObject);
    } else {
      throw new Exception("Please enter a numerical value");
    }
  } catch (Exception $e) {
    echo "<p>" . $e->getMessage() . "</p>";
  }
});

// Run it!
$router->run();

?>
