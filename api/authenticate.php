<?php

function verify_user_exists($username, $connectionObject)
{
  $password_query = <<<EOF
    SELECT password FROM users
    WHERE username = '$username'
    LIMIT 1
EOF;

  $results = $connectionObject->initiateQueries()->query($password_query);
  while ($get_password = $results->fetch_assoc()) {
    $password = $get_password["password"];
  }
  $connectionObject->closeConnection();
  return [$results->num_rows, $password];
}

?>
