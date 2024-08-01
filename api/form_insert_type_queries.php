<?php
function upsert_latest_user_workouts($workouts, $connectionObject)
{
  $pushups = $workouts["pushups"];
  $situps = $workouts["situps"];
  $dips = $workouts["dips"];
  $running = $workouts["running"];
  $jumpingjacks = $workouts["jumpingjacks"];
  $burpees = $workouts["burpees"];

  $update_workouts_for_a_user_query = <<<EOF
    UPDATE workouts, users
    SET push_ups = $pushups, sit_ups = $situps, dips = $dips, running = $running, jumping_jacks = $jumpingjacks, burpees = $burpees
    WHERE users.first_name = 'Sean' AND users.last_name = 'Fields' AND workouts.active_user_id = users.user_id;
EOF;

  $connectionObject
    ->initiateQueries()
    ->query($update_workouts_for_a_user_query);

  $connectionObject->closeConnection();
}

?>
