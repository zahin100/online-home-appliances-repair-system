<?php
include 'connect.php';

$id = $_GET['id'];

// delete selected item
$sql = "DELETE FROM inventory WHERE inventoryID=$id";
mysqli_query($connection, $sql);

header("Location: staff_inventory.php");
exit();
