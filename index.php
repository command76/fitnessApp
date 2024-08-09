<!DOCTYPE html>
<?php require dirname(__FILE__, 1) . "/pages/login/login.php"; ?>

<?php if (isset($username)) {
  echo "<h1>Hello $username</h1>";
  echo "<p><a href='/api/router/logged_in/$username/progress_pictures'>Add new current progress pictures</a></p>";
  echo "<p><a href='/api/router/logged_in/$username/workouts'>Wanna update your workouts?</a></p>";
} else {
  login();
  echo "<a href='/api/router/registration_page'>Create an account</a>";
} ?>
