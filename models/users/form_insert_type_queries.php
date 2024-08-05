<?php
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

?>
