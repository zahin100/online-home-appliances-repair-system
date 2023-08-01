<?php
include 'dbconnection.php';

// update repair or shipment status
if (isset($_POST['btnUpdateRepairStatus'])) {
    $repairID = $_GET['repairID'];
    $updateRepairStatus = $_POST['updateRepairStatus'];

    $updateSql = "UPDATE repairrequest SET repairStatus = '$updateRepairStatus' WHERE repairRequestID = '$repairID'";
    if (!mysqli_query($conn, $updateSql)) {
        echo ("Error description: " . mysqli_error($connection));
    }

    header("Location: staff_repairRequest.php");
    exit();
} else if (isset($_POST['btnUpdateShipmentStatus'])) {
    $repairID = $_GET['repairID'];
    $updateShipmentStatus = $_POST['updateShipmentStatus'];

    $updateSql = "UPDATE repairrequest SET deliveryStatus = '$updateShipmentStatus' WHERE repairRequestID = '$repairID'";
    if (!mysqli_query($conn, $updateSql)) {
        echo ("Error description: " . mysqli_error($connection));
    }

    header("Location: staff_repairRequest.php");
    exit();
}
