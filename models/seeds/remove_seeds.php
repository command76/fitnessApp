<?php

function delete_recent_users($number, $connectionObject)
{
  if (!is_numeric($number)) {
    print_r("Please add a numerical amount");
    return;
  } elseif (preg_match("/^\d{0,2}$/", $number) && $number != 0) {
    $delete_most_recent_users_query = <<<EOF
  DELETE FROM USERS
  ORDER BY user_id DESC
  LIMIT $number;
EOF;

    $connectionObject
      ->initiateQueries()
      ->query($delete_most_recent_users_query);

    $connectionObject->closeConnection();
  } else {
    print_r("Enter amount between 0 and 100");
  }
}

function delete_users_by_name($name, $number, $connectionObject)
{
  $errors = [];

  // address why special characters are being passed like letters

  try {
    if (is_numeric($number)) {
      preg_match("/^\d{0,2}$/", $number) && $number != 0
        ? ($valid_number = $number)
        : throw new Exception("Please enter amount between 1 and 99");
    } else {
      throw new Exception("Please enter a valid number");
    }
  } catch (Exception $e) {
    array_push($errors, $e->getMessage());
  }
  try {
    if (preg_match("/[A-Za-z]+/", $name[0])) {
      $fname = $name[0];
    } else {
      throw new Exception("Enter a valid first name");
    }
  } catch (Exception $e) {
    array_push($errors, $e->getMessage());
  }
  try {
    if (preg_match("/[A-Za-z]+/", $name[1])) {
      $lname = $name[1];
    } else {
      throw new Exception("Enter a valid last name");
    }
  } catch (Exception $e) {
    array_push($errors, $e->getMessage());
  }

  if (count($errors)) {
    print_r($errors);
  } else {
    $delete_user_by_full_name_query = <<<EOF
    DELETE FROM USERS
    WHERE first_name = '$fname' && last_name = '$lname'
    ORDER BY user_id DESC
    LIMIT $valid_number;
EOF;

    $connectionObject
      ->initiateQueries()
      ->query($delete_user_by_full_name_query);

    $connectionObject->closeConnection();
  }
}

?>
