<?php

function get_random_users($number, $connectionObject)
{
  $i = 0;

  $generate_last_name = [
    "Fields",
    "Romero",
    "Liu",
    "Huffman",
    "Baxter",
    "Gallegos",
    "Oliver",
    "Ingram",
    "Dunlap",
    "Frost",
    "Osborne",
    "Vance",
    "Carr",
    "Conner",
    "Lara",
    "McDowell",
    "Fleming",
    "Rosario",
    "Hopkins",
    "Villanueva",
    "Hunt",
    "Cherry",
    "Bishop",
    "Conway",
    "Hall",
    "Hood",
    "Xiong",
    "Brady",
    "Dejesus",
    "Bruce",
    "Adams",
    "Fuller",
    "Barajas",
    "Giles",
    "Ruiz",
    "Reilly",
    "Arroyo",
    "Bowers",
    "Fox",
    "Bennett",
    "Cummings",
    "Foster",
    "Mills",
    "Hudson",
    "Person",
    "Massey",
    "Schultz",
    "Knapp",
    "Hendrix",
    "Correa",
    "Church",
    "Harrison",
    "Conley",
    "Gould",
    "Bradley",
    "Mullen",
    "Eaton",
    "Fuentes",
    "Morton",
    "Guevara",
    "Craig",
    "Farrell",
    "Wu",
    "Vazquez",
    "Hess",
    "Daniels",
    "Martin",
    "Bryant",
    "Compton",
    "Tucker",
    "Rogers",
    "Crawford",
    "Munoz",
    "Underwood",
    "Byrd",
    "Barnes",
    "Duarte",
    "Johnston",
    "Mejia",
    "Ballard",
    "Powers",
    "Vaughan",
    "Underwood",
    "Lester",
    "Savage",
    "Michael",
    "Compton",
    "Conley",
    "Phan",
    "Chapman",
    "Ponce",
    "Perry",
    "Garrison",
    "Terry",
    "Frye",
    "Leon",
    "Wilson",
    "Bell",
    "Bentley",
    "Hawkins",
  ];

  $generate_first_name = [
    "Emersyn",
    "Clayton",
    "Eliza",
    "Pedro",
    "Hayley",
    "Tomas",
    "Ari",
    "Karson",
    "Katie",
    "Aries",
    "Paula",
    "Augustus",
    "Maxine",
    "Kash",
    "Alondra",
    "Caiden",
    "Rayna",
    "Fernando",
    "Louisa",
    "Ali",
    "Monroe",
    "Jesus",
    "Nyomi",
    "Paxton",
    "Ryann",
    "Thomas",
    "Briana",
    "Azrael",
    "Ryan",
    "Rio",
    "Marilyn",
    "Hudson",
    "Oakley",
    "Brennan",
    "Bailee",
    "Austin",
    "Tori",
    "Alberto",
    "Elisa",
    "Antonio",
    "Josephine",
    "Raiden",
    "Brielle",
    "Alex",
    "Kamila",
    "Moses",
    "Clementine",
    "Cody",
    "Linda",
    "Korbyn",
    "Valery",
    "Terrance",
    "Jasmine",
    "Marvin",
    "Violeta",
    "Richard",
    "Shay",
    "Leighton",
    "Madeleine",
    "Roland",
    "Teresa",
    "Odin",
    "Kassidy",
    "Kyson",
    "Journee",
    "Lawrence",
    "Ember",
    "Mateo",
    "Parker",
    "Abner",
    "Esther",
    "Colton",
    "Aubree",
    "Justin",
    "Ensley",
    "Cristian",
    "Liliana",
    "Abdullah",
    "Laila",
    "Atticus",
    "Alejandra",
    "Sean",
    "Nancy",
    "Reece",
    "Averi",
    "Keaton",
    "Aubriella",
    "Abner",
    "Salem",
    "Maison",
    "Zuri",
    "Langston",
    "Clara",
    "Noe",
    "Wren",
    "Franco",
    "Amora",
    "Daniel",
    "Melody",
    "Randy",
  ];

  while ($i < $number) {
    $first_name = $generate_first_name[rand(0, 99)];
    $last_name = $generate_last_name[rand(0, 99)];
    $username = $first_name . $last_name;

    $password = password_hash("password", PASSWORD_DEFAULT);

    $post_query = <<<EOF
INSERT INTO users (birthday, first_name, last_name, email, username, password, updated_at, created_at, is_enabled, before_pic, after_pic) VALUES ('2005-12-02', '$first_name', '$last_name', '{$first_name}_{$last_name}@famous_star.com', '$username', '$password', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1, 'before_weight_loss.jpg', 'after_weight_loss.jpg');
EOF;
    $connectionObject->initiateQueries()->query($post_query);

    $i++;
  }
  $connectionObject->closeConnection();
  inject_random_workouts($number, $connectionObject);
}

function get_predefined_user($fname, $lname, $connectionObject)
{
  $i = 0;
  $number = 1;
  while ($i < $number) {
    $post_query = <<<EOF
INSERT INTO users (birthday, first_name, last_name, email, updated_at, created_at, is_enabled, before_pic, after_pic) VALUES ('2005-12-02', '$fname', '$lname', '{$fname}_{$lname}@famous_star.com', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1, 'before_weight_loss.jpg', 'after_weight_loss.jpg');
EOF;
    $connectionObject->initiateQueries()->query($post_query);
    $i++;
  }
  $connectionObject->closeConnection();
  inject_random_workouts($number = 1, $connectionObject);
}

function inject_random_workouts($number, $connectionObject)
{
  $get_query = <<<EOF
SELECT * FROM users
WHERE updated_at > (now() - INTERVAL 1 SECOND)
ORDER BY user_id ASC
LIMIT $number;
EOF;

  $get_ids = $connectionObject->initiateQueries()->query($get_query);

  while ($result = $get_ids->fetch_assoc()) {
    $get_random_pushups = rand(0, 100);
    $get_random_situps = rand(0, 100);
    $get_random_dips = rand(0, 100);
    $get_random_running = rand(0, 30);
    $get_random_jumping_jacks = rand(0, 100);
    $get_random_burpees = rand(0, 100);
    $post_workout_query = <<<EOF
  INSERT INTO workouts (push_ups, sit_ups, dips, running, jumping_jacks, burpees, active_user_id) VALUES ($get_random_pushups, $get_random_situps, $get_random_dips, $get_random_running, $get_random_jumping_jacks, $get_random_burpees, $result[user_id])
EOF;
    $connectionObject->initiateQueries()->query($post_workout_query);
  }
  $connectionObject->closeConnection();
}

?>
