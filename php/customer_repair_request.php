<?php
include 'dbconnection.php';
include 'Customer.php';
session_start();

// get customer details
$customer = $_SESSION['customer'];
$customerID = $customer->getCustomerID();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Repair Request Details</title>
    <link rel="stylesheet" href="../css/customerStyle.css" />
    <link rel="stylesheet" href="../css/customerIndex2NavMenu.css" />
    <script src="https://kit.fontawesome.com/1b607b98d1.js" crossorigin="anonymous"></script>
</head>

<body id="cust_repairRequest">
    <!-- log out button -->
    <header id="header_welcome">
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

    <h1 id="h1_formName">Your Repair Request</h1>

    <!-- display customer repair request history -->
    <table id="requestDetailsTable">

        <?php
        $query = "SELECT * FROM repairrequest WHERE customerID='$customerID' ORDER BY date DESC;";
        $result = mysqli_query($conn, $query);
        $count = mysqli_num_rows($result);

        if ($count == 0) {
            echo '<div class="tableEmpty">No repair request history.</div>';
        } else { ?>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Brand</th>
                <th>Description</th>
                <th>Total Price (RM)</th>
                <th>Repair Status</th>
                <th>Payment Status</th>
                <th>Shipment Status</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) {
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
                    <td><span class="<?php echo $row['repairStatus']; ?>"><?php echo $row['repairStatus']; ?></span></td>
                    <td><span class="<?php echo $row['paymentStatus']; ?>"><?php echo $row['paymentStatus']; ?></span></td>
                    <td><span class="<?php echo $row['deliveryStatus']; ?>"><?php echo $row['deliveryStatus']; ?></span></td>
                </tr>
        <?php
            }
        }
        ?>

    </table>
</body>

</html>