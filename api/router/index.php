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
$router->get("/logged_in/{user}", function ($user) {
  echo "logged in" . $user;
});
$router->before("GET", "/logged_in/{user}", function () {
  $connectionObject = new DB\connection();
  // Store session here
});
$router->mount("/models", function () use ($router) {
  $router->mount("/seeds", function () use ($router) {
    $router->post("/random_users/", function () {
      $connectionObject = new DB\connection();
      isset($_GET["amount"])
        ? get_random_users($_GET["amount"], $connectionObject)
        : print_r("Please add amount to URL params");
    });
    $router->post("/predefined_user/", function () {
      $connectionObject = new DB\connection();

      isset($_GET["fname"]) && isset($_GET["lname"])
        ? get_predefined_user($_GET["fname"], $_GET["lname"], $connectionObject)
        : print_r("Please add fname and/or lname to url params");
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
      isset($_GET["amount"])
        ? delete_recent_users($_GET["amount"], $connectionObject)
        : print_r("Please add a amount to the url params");
    });
    $router->delete("/delete_users_by_name/", function () {
      $connectionObject = new DB\connection();
      !isset($_GET["amount"]) ? ($amount = 1) : ($amount = $_GET["amount"]);

      isset($_GET["first_name"]) && isset($_GET["last_name"])
        ? delete_users_by_name(
          [$_GET["first_name"], $_GET["last_name"]],
          $amount,
          $connectionObject
        )
        : print_r(
          "Please enter first_name and/or last_name and/or optionally amount into the url params"
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
  isset($_GET["username"]) && isset($_GET["password"])
    ? authenticate($_GET["username"], $_GET["password"], $connectionObject)
    : print_r("Please add username and password to url params");
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
