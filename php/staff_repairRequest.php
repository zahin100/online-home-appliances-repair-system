<?php
include 'staff_sidebarMenu.php';
include 'dbconnection.php';

// get total numbe rof repair requests
$sql = "SELECT COUNT(repairRequestID) AS numRepairRequest FROM repairrequest";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $numRepairRequest = $row["numRepairRequest"];
    }
} else {
    echo "0 results";
}

// get number of repair completed
$sql = "SELECT COUNT(repairRequestID) AS numRepairCompleted FROM repairrequest WHERE repairStatus = 'Completed'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $numRepairCompleted = $row["numRepairCompleted"];
    }
} else {
    echo "0 results";
}

// get number of repair pending
$sql = "SELECT COUNT(repairRequestID) AS numRepairPending FROM repairrequest WHERE repairStatus = 'Pending'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $numRepairPending = $row["numRepairPending"];
    }
} else {
    echo "0 results";
}

// get number of shipment pending
$sql = "SELECT COUNT(repairRequestID) AS numShipmentPending FROM repairrequest WHERE deliveryStatus = 'Pending'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $numShipmentPending = $row["numShipmentPending"];
    }
} else {
    echo "0 results";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Repair Requests</title>
    <link rel="stylesheet" href="../css/staffEachPage.css">
</head>

<body>
    <div class="repairRequestPage">

        <div class="cardBox">
            <div class="card">
                <div>
                    <!-- display total number of repair requests -->
                    <div class="numbers"><?php echo $numRepairRequest ?></div>
                    <div class="cardName">Total Repair Requests</div>
                </div>
                <div class="iconBox">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                </div>
            </div>
            <div class="card">
                <div>
                    <!-- display number of repair completed -->
                    <div class="numbers"><?php echo $numRepairCompleted ?></div>
                    <div class="cardName">Repair Completed</div>
                </div>
                <div class="iconBox">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
            <div class="card">
                <div>
                    <!-- display number of repair pending -->
                    <div class="numbers"><?php echo $numRepairPending ?></div>
                    <div class="cardName">Repair Pending</div>
                </div>
                <div class="iconBox">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>
            </div>
            <div class="card">
                <div>
                    <!-- display number of shipment pending -->
                    <div class="numbers"><?php echo $numShipmentPending ?></div>
                    <div class="cardName">Shipment Pending</div>
                </div>
                <div class="iconBox">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
            </div>
        </div>

        <br>
        <!-- display repair requests -->
        <h2 id="titleRepairRequest">REPAIR REQUEST</h2>
        <div class="tableRepairRequest">
            <table>
                <tr>
                    <th>Request ID</th>
                    <th>Date</th>
                    <th>Customer ID</th>
                    <th>Repair Status</th>
                    <th>Payment Status</th>
                    <th>Shipment Status</th>
                    <th></th>
                </tr>

                <?php
                $query = "SELECT repairRequestID, DATE_FORMAT(date, '%d-%m-%Y') AS date, customerID, repairStatus, paymentStatus, deliveryStatus FROM repairrequest ORDER BY repairRequestID DESC;";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?php echo $row['repairRequestID']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['customerID']; ?></td>
                        <td><span class="<?php echo $row['repairStatus']; ?>"><?php echo $row['repairStatus']; ?></span></td>
                        <td><span class="<?php echo $row['paymentStatus']; ?>"><?php echo $row['paymentStatus']; ?></span></td>
                        <td><span class="<?php echo $row['deliveryStatus']; ?>"><?php echo $row['deliveryStatus']; ?></span></td>
                        <td>
                            <form action="staff_repairDetails.php?repairRequestID=<?php echo $row['repairRequestID']; ?>" method="POST"><button type="submit" id="btnViewRepairDetails">View Repair Details</button></form>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>