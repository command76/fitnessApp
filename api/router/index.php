<?php
// Require composer autoloader
require __DIR__ . '../../vendor/autoload.php';

// Create Router instance
$router = new \Bramus\Router\Router();
$router->get('/hello', function() {
    echo "<p>hello</p>"
})

// Define routes
// ...

// Run it!
$router->run();

?>