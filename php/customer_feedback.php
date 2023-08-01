<?php
include 'dbconnection.php';
include 'Customer.php';
session_start();
$customer = $_SESSION['customer'];
$customerID = $customer->getCustomerID();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $rating = $_POST["rating"];
  $comments = $_POST["comments"];

  $insertSql = "INSERT INTO feedback (customerID, star, description) VALUES ('$customerID', '$rating', '$comments')";
  mysqli_query($conn, $insertSql);


  echo "<script>
        window.location.href='../html/customer_feedback.html';
        alert('Your feedback has been submitted!');
        </script>";
}
