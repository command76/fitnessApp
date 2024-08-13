<!DOCTYPE html>
<?php
list($_SERVER["PHP_AUTH_USER"], $_SERVER["PHP_AUTH_PW"]) = explode(
  ":",
  base64_decode(substr($_SERVER["HTTP_AUTHORIZATION"], 6))
);
require dirname(__FILE__, 1) . "/pages/login/login.php";
?>

<?php if (!isset($_SERVER["PHP_AUTH_USER"])) {
  header('WWW-Authenticate: Basic realm="Test"');
  header("HTTP/1.0 401 Unauthorized");
  login();
  echo "<a href='/api/router/registration_page'>Create an account</a>";
  exit();
} else {
  // if (
  //   authenticate(
  //     $_SERVER["PHP_AUTH_USER"],
  //     $_SELF["PHP_AUTH_PW"],
  //     $connectionObject
  //   )
  // ) {

  echo "<h1>Hello {$_SERVER["PHP_AUTH_USER"]}</h1>";
  echo "<p><a href='/api/router/logged_in/{$_SERVER["PHP_AUTH_USER"]}/progress_pictures'>Add new current progress pictures</a></p>";
  echo "<p><a href='/api/router/logged_in/{$_SERVER["PHP_AUTH_USER"]}/workouts'>Wanna update your workouts?</a></p>"; // } else {
  //   echo "SKSDKSDKSDK";
  // header('WWW-Authenticate: Basic realm="Fitness App"');
  // login();
  // echo "<a href='/api/router/registration_page'>Create an account</a>";
  // }
  // echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}.</p>";
  // echo "<p>You entered {$_SERVER['PHP_AUTH_PW']} as your password.</p>";
} // if (isset($username)) {
//   echo "<h1>Hello $username</h1>";
//   echo "<p><a href='/api/router/logged_in/$username/progress_pictures'>Add new current progress pictures</a></p>";
//   echo "<p><a href='/api/router/logged_in/$username/workouts'>Wanna update your workouts?</a></p>";
// } else {
//   login();
//   echo "<a href='/api/router/registration_page'>Create an account</a>";
// }
?>
