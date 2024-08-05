<?php

function delete_recent_users($number, $connectionObject)
{
  $delete_most_recent_users_query = <<<EOF
  DELETE FROM USERS
  ORDER BY user_id DESC
  LIMIT $number;
EOF;

  $connectionObject->initiateQueries()->query($delete_most_recent_users_query);

  $connectionObject->closeConnection();
}

function delete_users_by_name($name, $number, $connectionObject)
{
  $fname = $name[0];
  $lname = $name[1];

  $delete_user_by_full_name_query = <<<EOF
    DELETE FROM USERS
    WHERE first_name = '$fname' && last_name = '$lname'
    ORDER BY user_id DESC
    LIMIT $number;
EOF;

  $connectionObject->initiateQueries()->query($delete_user_by_full_name_query);

  $connectionObject->closeConnection();
}

?>
