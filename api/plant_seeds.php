<?php
require "../connection.php";

use dbconnecting as DB;
$connectionObject = new DB\connection();
$connectionObject->connectionAttempt();
// $connectionObject->closeConnection();
// DB\runQuery("INSERT INTO users (birthday, first_name, last_name, email, updated_at, created_at, is_enabled, before_pic, after_pic) VALUES (2005-12-02, Tom, Cruise, tom_cruise@famous_star.com, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, TRUE, before_weight_loss.jpg, after_weight_loss.jpg");
// if used as a function

$number = 1;


$post_query = <<<EOF
USE fitnessApp;
INSERT INTO users (birthday, first_name, last_name, email, updated_at, created_at, is_enabled, before_pic, after_pic) VALUES ('2005-12-02', 'Tom', 'Cruise', 'tom_cruise@famous_star.com', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1, 'before_weight_loss.jpg', 'after_weight_loss.jpg');
EOF;

// $connectionObject->runQuery->multi_query($post_query);
$connectionObject->runMultiQuery($post_query);

$get_query =  <<<EOF
USE fitnessApp;
SELECT user_id FROM users
ORDER BY user_id DESC
LIMIT {$number}
EOF;

$value = $connectionObject\conn->query($get_query);
echo $value;
$connectionObject->closeConnection();
?>


<!-- USE fitnessApp;
INSERT INTO users (birthday, first_name, last_name, email, updated_at, created_at, is_enabled, before_pic, after_pic) VALUES ("2005-12-02",
"Thomas",
"Cruises",
"tom_cruise@famous_star.com",
CURRENT_TIMESTAMP,
CURRENT_TIMESTAMP,
1,
"before_weight_loss.jpg", 
"after_weight_loss.jpg"
);
SELECT user_id ui FROM users
WHERE first_name = "Thomas" AND last_name = "Cruises"
UNION
INSERT INTO workouts (active_user_id) VALUES (ui);


INSERT INTO workouts (push_ups, sit_ups, dips, running,	jumping_jacks, burpees,	active_user_id) VALUES (12, 50, 50, 2 miles, 100, users.user_id" -->
