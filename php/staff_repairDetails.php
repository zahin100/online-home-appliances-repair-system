<?php
session_start();
include 'dbconnection.php';
include 'staff_sidebarMenu.php';
include 'Inventory.php';
$repairRequestID = $_GET['repairRequestID'];

// get inventory details
$query = "SELECT * FROM inventory";
$result = mysqli_query($conn, $query);
$i = 0;

$inventoryID = array();
$name = array();
$image = array();
$price = array();
$quantity = array();


while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $inventoryID[$i] = $row['inventoryID'];
    $name[$i] = $row['name'];
    $image[$i] = $row['image'];
    $price[$i] = $row['price'];
    $quantity[$i] = $row['quantity'];
    ++$i;
}


$inventory = new Inventory($inventoryID, $name, $image, $price, $quantity);
$_SESSION['inventory'] = $inventory;

// get repair requests
$query = "SELECT * FROM repairrequest WHERE repairRequestID = '$repairRequestID'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$customerID = $row['customerID'];
$date = $row['date'];
$image = $row['image'];
$type = $row['type'];
$brand = $row['brand'];
$description = $row['description'];
$repairStatus = $row['repairStatus'];
$paymentStatus = $row['paymentStatus'];
$paymentFile = $row['paymentFile'];
$deliveryStatus = $row['deliveryStatus'];
$totalRepairPrice = $row['totalPrice'];
$shippingAddress = $row['shippingAddress'];
?>

<?php

// calculate total price
if (isset($_POST['btnCalculatePrice'])) {


    $totalPrice = 0;
    $price = $inventory->getPrice();


    for ($j = 0; $j < sizeof($inventory->getInventoryID()); $j++) {

        if (isset($_POST["$j"])) {
            $quantity = $_POST["$j"];
            $itemPrice = $price[$j];
            $totalPrice += (int)$quantity * $itemPrice;
        }
    }

    $sql = "UPDATE repairrequest SET totalPrice='$totalPrice' WHERE repairRequestID='$repairRequestID'";

    if ($conn->query($sql) === TRUE) {
    } else {
        echo "Error updating record: " . $conn->error;
    }

    header("Refresh:0");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Repair Details</title>
    <link rel="stylesheet" href="../css/staffEachPage.css">

</head>

<body>
    <h2 id="titleRepairDetails">Repair Details</h2>

    <!-- calculate total price form -->
    <div id="myPopup3" class="popup3">
        <div class="popup-content3">
            <h2 id="titleCalculatePrice">
                Enter Spare Parts Used
            </h2>

            <form method="POST">

                <?php

                for ($i = 0; $i < sizeof($inventory->getInventoryID()); $i++) {
                    $name = $inventory->getName();
                    $itemName = $name[$i];
                    $maxQuantity = $inventory->getQuantity();
                    $maxItem = $maxQuantity[$i];
                ?>

                    <b> <?php echo $itemName ?> </b><br>
                    <input type='number' name='<?php echo $i ?>' min='0' max='<?php echo $maxItem ?>'><br><br>

                <?php } ?>

                <button type="submit" id="btnCalculatePrice" name="btnCalculatePrice" class="calculate-button">Calculate Total Price</button>
            </form>
            <button onclick="removePopupForm()" id="closePopup3">
                Cancel
            </button>
        </div>
    </div>

    <!-- display repair request details -->
    <div class="repairDetailsTable">
        <table style="width:100%">
            <tr>
                <th>Repair ID:</th>
                <td><?php echo $repairRequestID ?></td>
            </tr>
            <tr>
                <th>Customer ID:</th>
                <td><?php echo $customerID ?></td>
            </tr>
            <tr>
                <th>Date:</th>
                <td><?php echo $date ?></td>
            </tr>
            <tr>
                <th>Appliance image:</th>
                <td><img width="300" height="300" src="../repairImages/<?php echo $image ?>"></td>
            </tr>
            <tr>
                <th>Appliance type:</th>
                <td><?php echo $type ?></td>
            </tr>
            <tr>
                <th>Appliance brand:</th>
                <td><?php echo $brand ?></td>
            </tr>
            <tr>
                <th>Problem description:</th>
                <td><?php echo $description ?></td>
            </tr>
            <tr>
                <th>Repair status:</th>
                <td>
                    <div>
                        <form action="staff_statusUpdate.php?repairID=<?php echo $repairRequestID ?>" method="POST" onsubmit="return confirm('Are you sure to update the repair status?')">
                            <select name="updateRepairStatus">
                                <option value="Pending">Pending</option>
                                <option value="Completed">Completed</option>
                            </select>
                            <br><br><button type="submit" name="btnUpdateRepairStatus" id="btnUpdateRepairStatus" inline="TRUE">Update Repair Status</button>
                        </form>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Total price:</th>
                <td>
                    <button id="selectItemButton" name="selectItemButton" class="calculate-button">Enter Spare Part Used</button><br>
                    <br><input type="text" id="displayTotalPrice" value="RM <?php echo $totalRepairPrice ?>" readonly>
                </td>
            </tr>
            <tr>
                <th>Payment status:</th>
                <td><span class="<?php echo $paymentStatus ?>"><?php echo $paymentStatus ?></span></td>
            </tr>
            <tr>
                <th>Payment file:</th>
                <td><button <?php if ($paymentFile == "") {
                                echo "disabled";
                            } ?> class="btnDownloadFile"><i class="fa fa-download"></i><a <?php if ($paymentFile == "") {
                                                                                                echo 'style="pointer-events: none"';
                                                                                            } ?> href="../paymentFile/<?php echo $paymentFile ?>" id="linkDownloadFile" download>Download Payment File</button></td>
            </tr>
            <tr>
                <th>Shipment Status:</th>
                <td>
                    <div>
                        <form action="staff_statusUpdate.php?repairID=<?php echo $repairRequestID ?>" method="POST" onsubmit="return confirm('Are you sure to update the shipment status?')">
                            <select name="updateShipmentStatus">
                                <option value="Pending">Pending</option>
                                <option value="Shipped">Shipped</option>
                            </select>
                            <br><br><button type="submit" name="btnUpdateShipmentStatus" id="btnUpdateShipmentStatus" inline="TRUE">Update Shipment Status</button>
                        </form>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Shipping Address:</th>
                <td><?php echo $shippingAddress ?></td>
            </tr>
        </table>
        <br>
        <form action="staff_repairRequest.php"><button type="submit" id="btnBack">Back</button></form>
    </div>

    <script>
        selectItemButton.addEventListener("click", function() {
            myPopup3.classList.add("show3");
        });
        closePopup3.addEventListener("click", function() {
            myPopup3.classList.remove("show3");
        });
        window.addEventListener("click", function(event) {
            if (event.target == myPopup3) {
                myPopup3.classList.remove("show3");
            }
        });
    </script>
</body>

</html>