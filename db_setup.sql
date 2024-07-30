CREATE DATABASE IF NOT EXISTS fitnessApp;
CREATE TABLE fitnessApp.users (
    user_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    birthday DATE,
    first_name VARCHAR(25),
    last_name VARCHAR(25),
    email VARCHAR(254),
    updated_at TIMESTAMP,
    created_at TIMESTAMP,
    is_enabled BOOLEAN,
    before_pic LONGBLOB NOT NULL,
    after_pic LONGBLOB NOT NULL,
    PRIMARY KEY(user_id)) ENGINE=INNODB;
CREATE TABLE fitnessApp.workouts (
    workout_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    push_ups INT,
    sit_ups INT,
    dips INT,
    running INT,
    jumping_jacks INT,
    burpees INT,
    active_user_id INT UNSIGNED NOT NULL,
    PRIMARY KEY(workout_id),
    FOREIGN KEY (active_user_id) 
        REFERENCES users(user_id) 
        ON UPDATE CASCADE 
        ON DELETE CASCADE
) ENGINE=INNODB;