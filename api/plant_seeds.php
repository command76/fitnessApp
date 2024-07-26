<?php
require "../connection.php";

use dbconnecting as DB;
$connectionObject = new DB\connection();
$connectionObject->connectionAttempt();

$number = 2;

$post_query = <<<EOF
USE fitnessApp;
INSERT INTO users (birthday, first_name, last_name, email, updated_at, created_at, is_enabled, before_pic, after_pic) VALUES ('2005-12-02', 'Tom', 'Cruise', 'tom_cruise@famous_star.com', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1, 'before_weight_loss.jpg', 'after_weight_loss.jpg');
EOF;

$connectionObject->initiateQueries()->multi_query($post_query);

$get_query = <<<EOF
SELECT * FROM users
ORDER BY user_id DESC
LIMIT 2;
EOF;

$get_ids = $connectionObject->initiateQueries()->query($get_query);
while ($result = $get_ids->fetch_assoc()) {
  echo $result["user_id"];
  $post_workout_query = <<<EOF
  INSERT INTO workouts (push_ups, sit_ups, dips, running, jumping_jacks, burpees, active_user_id) VALUES (12, 50, 50, 8, 100, 50, $result[user_id])
EOF;
  $connectionObject->initiateQueries()->query($post_workout_query);
}

$connectionObject->closeConnection();
?>
