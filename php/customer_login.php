<?php
include 'dbconnection.php';
include 'Customer.php';
session_start();

$username = $_POST['login_username'];
$rawPassword = $_POST['login_password'];

// get customer details
$query = "SELECT password FROM customer WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$hashed_pass = $row["password"];

// check if password is correct
if (password_verify($rawPassword, $hashed_pass) == false) {

    echo "<script>
    window.location.href='../html/customer_login.html';
     alert('INCORRECT USERNAME OR PASSWORD!');
     </script>";
} else {
    $statement = "select * from customer where username = '$username'";
    $result = mysqli_query($conn, $statement);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
    if ($count == 1) {


        $customer = new Customer($row['customerID'], $row['name'], $row['email'], $row['phoneNumber'], $row['address']);
        $_SESSION['customer'] = $customer;

        echo "<script>
        window.location.href='customer_repair_request.php';
        </script>";
    } else {
        echo "<script>
        window.location.href='../html/customer_login.html';
        alert('INCORRECT USERNAME OR PASSWORD!');
        </script>";
    }
}
