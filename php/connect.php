<?php
$host = 'localhost';        // Hostname
$username = 'root';         // MySQL username
$password = '';             // MySQL password
$database = 'webproject';   // Database name

// Create a connection
$connection = mysqli_connect($host, $username, $password, $database);

// Check the connection
if (!$connection) {
    die('Connection failed: ' . mysqli_connect_error());
}
