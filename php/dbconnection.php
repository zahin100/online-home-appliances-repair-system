<?php
// database connection details
$serverName = "localhost";
$username = "root";
$password = "";
$dbName = "webproject";

$conn = mysqli_connect($serverName, $username, $password, $dbName) or trigger_error("Unable to connect to the database");
