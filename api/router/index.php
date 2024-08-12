<?php
// tomorrow work on logging into the app
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
require dirname(__FILE__, 3) . "/models/users/form_insert_type_queries.php";
ob_end_clean();

// Create Router instance
$router = new \Bramus\Router\Router();

// Example class and namespace
// $user = new \Controllers\User();

// Example Class@method
// $router->get("/users/{user}", "\Controllers\User@isEnabled");

// Define routes
$router->get("/", function () {
  header("Location: /pages/login/login.php");
});
$router->get("/registration_page/", function () {
  header("Location: /pages/register/register.php");
});
$router->mount("/logged_in", function () use ($router) {
  $router->get("/", function () {
    header("Location: /pages/user/dashboard.php");
  });
  $router->get("/{user}/workouts", function ($user) {
    header("Location: /pages/user/user_workouts_home.php");
  });
  $router->get("/{user}/progress_pictures", function ($user) {
    header("Location: /pages/user/progress_pictures.php");
  });
});
// $router->before("GET", "/logged_in/{user}", function () {
//   $connectionObject = new DB\connection();
//   // Store session here
// });
$router->mount("/authenticate/", function () use ($router) {
  $router->get("/from_url_string/", function () {
    $connectionObject = new DB\connection();
    isset($_GET["username"]) && isset($_GET["password"])
      ? authenticate($_GET["username"], $_GET["password"], $connectionObject)
      : print_r("Please add username and password to url params");
  });
  $router->post("/oauth/", function () {
    // work on this next
  });
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
    $router->post("/xml_feed_seeds/", function () {
      // add this eventually
    });
    $router->post("/csv_format_seeds/", function () {
      // add this eventually
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
    $router->post("/register_new_user/", function () {
      $connectionObject = new DB\connection();
      $errorArray = [];
      $userInput = [];
      if (isset($_POST["submit"])) {
        try {
          if (isset($_FILES["fileToUpload"]["name"])) {
            if ($_FILES["fileToUpload"]["name"] != null) {
              $target_dir = dirname(__FILE__, 3) . "/assets/uploads/";
              $target_file =
                $target_dir . basename($_FILES["fileToUpload"]["name"]);
              $uploadOk = 1;
              $imageFileType = strtolower(
                pathinfo($target_file, PATHINFO_EXTENSION)
              );
              $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

              if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
                move_uploaded_file(
                  $_FILES["fileToUpload"]["tmp_name"],
                  $target_file
                );
                $userInput["before_pic"] =
                  $_SERVER["SERVER_NAME"] .
                  ":" .
                  $_SERVER["SERVER_PORT"] .
                  "/assets/uploads/" .
                  $_FILES["fileToUpload"]["name"];
              } else {
                echo "File is not an image.";
                throw new Exception("File is not an image");
                $uploadOk = 0;
              }
            } else {
              return throw new Exception("Please enter before pic");
            }
          }
        } catch (Exception $e) {
          array_push($errorArray, $e->getMessage());
        }
        try {
          if (isset($_POST["birthday"])) {
            $userInput["birthday"] = $_POST["birthday"];
          } else {
            throw new Exception("Please enter birthday");
          }
        } catch (Exception $e) {
          array_push($errorArray, $e->getMessage());
        }

        try {
          if (isset($_POST["first_name"])) {
            $userInput["first_name"] = $_POST["first_name"];
          } else {
            throw new Exception("Please enter first name");
          }
        } catch (Exception $e) {
          array_push($errorArray, $e->getMessage());
        }

        try {
          if (isset($_POST["last_name"])) {
            $userInput["last_name"] = $_POST["last_name"];
          } else {
            throw new Exception("Please enter last name");
          }
        } catch (Exception $e) {
          array_push($errorArray, $e->getMessage());
        }

        try {
          if (isset($_POST["email"])) {
            $userInput["email"] = $_POST["email"];
          } else {
            throw new Exception("Please enter email");
          }
        } catch (Exception $e) {
          array_push($errorArray, $e->getMessage());
        }

        try {
          if (isset($_POST["username"])) {
            $userInput["username"] = $_POST["username"];
          } else {
            throw new Exception("Please enter a username");
          }
        } catch (Exception $e) {
          array_push($errorArray, $e->getMessage());
        }

        try {
          if (isset($_POST["password"])) {
            $userInput["password"] = $_POST["password"];
          } else {
            throw new Exception("Please enter a password");
          }
        } catch (Exception $e) {
          array_push($errorArray, $e->getMessage());
        }

        if (count($errorArray) > 0) {
          $userInput = $errorArray;
        }
        register_new_user($userInput, $connectionObject);
        // header("Location: /api/router/logged_in/$userInput[username]");
      } else {
        echo "NOOOO!";
      }
    });
  });
});
$router->post("/assets/progress_image/", function () {
  header("Location: /assets/upload.php");
});

// Run it!
$router->run();

?>
