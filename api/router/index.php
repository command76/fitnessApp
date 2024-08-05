<?php
// Start doing front end stuff
// allow user to login

// Require composer autoloader
ob_start();
require dirname(__FILE__, 3) . "/vendor/autoload.php";
require dirname(__FILE__, 3) . "/connection.php";
use dbconnecting as DB;
require dirname(__FILE__, 3) . "/models/seeds/plant_seeds.php";
require dirname(__FILE__, 3) . "/models/seeds/remove_seeds.php";
require dirname(__FILE__, 3) . "/controllers/users/user.php";
require dirname(__FILE__, 3) . "/index.php";
require dirname(__FILE__, 3) . "/controllers/login/authenticate.php";
ob_end_clean();

// Create Router instance
$router = new \Bramus\Router\Router();

// Example class and namespace
// $user = new \Controllers\User();

// Example Class@method
// $router->get("/users/{user}", "\Controllers\User@isEnabled");

// Define routes
$router->get("/", function () {
  header("Location: /");
});

$router->mount("/models", function () use ($router) {
  $router->mount("/seeds", function () use ($router) {
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
      if (
        preg_match("/[A-Za-z]+/", $fname) &&
        preg_match("/[A-Za-z]+/", $lname)
      ) {
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
    $router->post("/create_new_database/", function () {
      $connectionObject = new DB\connection();
      $connectionObject->connectionAttempt();
      $connectionObject->closeConnection();
    });
  });
  $router->mount("/users", function () use ($router) {
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
  });
});
$router->get("/authenticate_from_url_string/", function () {
  $connectionObject = new DB\connection();
  try {
    if (isset($_GET["username"]) && isset($_GET["password"])) {
      $username = $_GET["username"];
      $password = $_GET["password"];
    } else {
      throw new Exception("Please add a username and/or password");
    }
  } catch (Exception $e) {
    print_r($e->getMessage());
    return;
  }
  try {
    if (verify_user_exists($username, $connectionObject)[0] > 0) {
      $stored_hashed_password = verify_user_exists(
        $username,
        $connectionObject
      )[1];
    } else {
      throw new Exception("Username not found");
    }
  } catch (Exception $e) {
    print_r($e->getMessage());
    return;
  }
  try {
    if (password_verify($password, $stored_hashed_password)) {
      echo "We good dog!";
    } else {
      throw new Exception("Please enter correct password");
    }
  } catch (Exception $e) {
    print_r($e->getMessage());
    return;
  }
});
$router->post("/oauth/", function () {
  // work on this next
});
$router->post("/register/", function () {
  $user = "blah";

  header("Location: /api/router/user/$user");
});
$router->post("/upload_user_image/", function () {
  // eventually work on this
});
$router->post("/xml_feed_seeds/", function () {
  // add this eventually
});
$router->post("/csv_format_seeds/", function () {
  // add this eventually
});

// Run it!
$router->run();

?>
