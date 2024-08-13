<?php
require dirname(__FILE__, 3) . "/controllers/login/authenticate.php";

function upsert_latest_user_workouts($workouts, $connectionObject)
{
  $queriesArray = [];
  $errorsArray = [];

  foreach ($workouts as $key => $value) {
    $query = <<<EOF
    UPDATE workouts, users
    SET $key = $value
    WHERE users.first_name = 'Madeleine' AND users.last_name = 'Carr' AND workouts.active_user_id = users.user_id;
EOF;
    is_numeric($value) && $value < 100 && 0 < $value
      ? array_push($queriesArray, $query)
      : array_push($errorsArray, $key);
  }
  if ($errorsArray) {
    print_r(
      "Some fields did not update " .
        implode(" and ", $errorsArray) .
        " must have values between 1 and 99"
    );
  }
  $queriesString = implode("", $queriesArray);

  $connectionObject->initiateQueries()->multi_query($queriesString);

  $connectionObject->closeConnection();
}

function register_new_user($user_inputs, $connectionObject)
{
  // look at plant_seeds.php for example of inserting new user

  $password = password_hash($user_inputs["password"], PASSWORD_DEFAULT);
  $birthday = date("Y-m-d H:i:s", strtotime($user_inputs["birthday"]));
  $register_new_user_query = <<<EOF
  INSERT INTO users (birthday, first_name, last_name, email, username, password, updated_at, created_at, is_enabled, before_pic, after_pic) VALUES ('$birthday', '$user_inputs[first_name]', '$user_inputs[last_name]', '$user_inputs[email]', '$user_inputs[username]', '$password', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1, '$user_inputs[before_pic]', 'after_pic.jpg');        
EOF;
  $connectionObject->initiateQueries()->query($register_new_user_query);
  $connectionObject->closeConnection();

  $create_new_user_for_workouts = <<<EOF
  INSERT INTO workouts (active_user_id)
  SELECT user_id FROM users
  WHERE users.first_name = '$user_inputs[first_name]' AND users.last_name= '$user_inputs[last_name]' AND updated_at > (now() - INTERVAL 10 SECOND)
EOF;

  $connectionObject->initiateQueries()->query($create_new_user_for_workouts);
  $connectionObject->closeConnection();
}

?>
