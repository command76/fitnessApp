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
  return isset($password)
    ? [$results->num_rows, $password]
    : [0, "Username not found"];
}

function authenticate($username, $password, $connectionObject)
{
  try {
    if (verify_user_exists($username, $connectionObject)[0] > 0) {
      $stored_hashed_password = verify_user_exists(
        $username,
        $connectionObject
      )[1];
    } else {
      throw new Exception("Username not found");
    }
  } catch (Exception $e) {
    print_r($e->getMessage());
    return;
  }
  try {
    if (password_verify($password, $stored_hashed_password)) {
      echo "We good dog!";
    } else {
      throw new Exception("Please enter correct password");
    }
  } catch (Exception $e) {
    print_r($e->getMessage());
    return;
  }
}

?>
