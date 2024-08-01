<?php
function upsert_latest_user_workouts($workouts, $connectionObject)
{
  $queriesArray = [];

  foreach ($workouts as $key => $value) {
    $query = <<<EOF
    UPDATE workouts, users
    SET $key = $value
    WHERE users.first_name = 'Sean' AND users.last_name = 'Fields' AND workouts.active_user_id = users.user_id;
EOF;
    is_numeric($value) ? array_push($queriesArray, $query) : null;
  }
  $queriesString = implode("", $queriesArray);

  $connectionObject->initiateQueries()->multi_query($queriesString);

  $connectionObject->closeConnection();
}

?>
