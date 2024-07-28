<!DOCTYPE html>
<?php
require "./connection.php";
use dbconnecting as DB;
$connectionObject = new DB\connection();
$connectionObject->connectionAttempt();
$connectionObject->closeConnection();
?>
<?php echo "<h1>Index</h1>"; ?>
