<?php
// config.php
// Database connection details
define('DB_SERVER', 'localhost'); // Your database server (e.g., 'localhost')
define('DB_USERNAME', 'root'); // Your MySQL username
define('DB_PASSWORD', ''); // Your MySQL password
define('DB_NAME', 'product'); // Your database name (product)

// Attempt to connect to MySQL database
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>