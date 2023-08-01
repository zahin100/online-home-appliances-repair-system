<?php
include 'dbconnection.php';
include 'Customer.php';
session_start();

// get customer details
$customer = $_SESSION['customer'];
$customerID = $customer->getCustomerID();
$customerAddress = $customer->getAddress();
?>

<!DOCTYPE html>
<html>

<head>
  <title>Customer Payment</title>
  <link rel="stylesheet" href="../css/customerStyle.css" />
  <link rel="stylesheet" href="../css/customerIndex2NavMenu.css" />
  <script src="../js/customer_form_validation.js"></script>
  <script src="https://kit.fontawesome.com/1b607b98d1.js" crossorigin="anonymous"></script>
</head>

<body>
  <header id="header_welcome">
    <!-- log out button -->
    <div class="iconLogOut">
      <a href="customer_logout.php" onclick="return confirm('Are you sure you want to log out?')">
        <span class="icon"><i class="fa-solid fa-right-from-bracket"></i></span>
      </a>
    </div>
    <h1>Welcome To EZ Repair Customer Interface</h1>
  </header>

  <!-- Navigation Menu -->
  <nav id="index2_nav">
    <ul id="index2_ul">
      <li><a href="customer_repair_request.php">Your Repair Request</a></li>
      <li>
        <a href="customer_request_form.php">Make A New Repair Request</a>
      </li>
      <li><a href="customer_payment.php">Payment</a></li>
      <li><a href="../html/customer_feedback.html">Feedback</a></li>
    </ul>
  </nav>
  <h1 id="h1_formNamePayment">Your Pending Payment</h1>

  <!-- display pending payment to the customer -->
  <table id="paymentTable">

    <?php
    $query = "SELECT * FROM repairrequest WHERE customerID='$customerID' AND repairStatus='Completed' AND paymentStatus='Pending' ORDER BY date DESC;";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);

    if ($count == 0) {
      echo '<div class="tableEmpty">No pending payments.</div>';
    } else { ?>
      <tr>
        <th>Date</th>
        <th>Type</th>
        <th>Brand</th>
        <th>Description</th>
        <th>Total Price (RM)</th>
        <th></th>
      </tr>
      <?php
      while ($row = mysqli_fetch_assoc($result)) {
      ?>
        <tr>
          <td><?php echo $row['date']; ?></td>
          <td><?php echo $row['type']; ?></td>
          <td><?php echo $row['brand']; ?></td>
          <td><?php echo $row['description']; ?></td>
          <td><?php if ($row['totalPrice'] == 0.00) {
                echo "To Be Determined";
              } else {
                echo $row['totalPrice'];
              } ?></td>
          <td>
            <form action="customer_make_payment.php?repairRequestID=<?php echo $row['repairRequestID']; ?>&address=<?php echo $customerAddress; ?>" method="POST">
              <button type="submit" name="makePayment" class="add-button">Pay Now</button>
            </form>
          </td>
        </tr>
    <?php
      }
    }
    ?>

  </table>
</body>

</html>