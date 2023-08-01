<?php
include 'dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $name = $_POST["name"];
  $email = $_POST["email"];
  $username = $_POST["username"];
  $address = $_POST["address"];
  $phone = $_POST["phone"];
  $password = $_POST["password"];
  $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

  $sql = "SELECT username FROM customer WHERE username = '$username'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) == 1) {
    echo "<script>
        window.location.href='../html/customer_registration.html';
        alert('Username already exists!');
        </script>";
  } else {
    $insertSql = "INSERT INTO customer (name, email, phoneNumber, address,username,password) VALUES ('$name', '$email', '$phone', '$address','$username', '$hashed_pass')";
    // Execute the statement
    if (mysqli_query($conn, $insertSql)) {
      echo "<script>
        window.location.href='../html/customer_login.html';
        alert('Registration is successful!');
        </script>";
    } else {
      echo "Error registering the customer: " . $stmt->error;
    }
  }
}
