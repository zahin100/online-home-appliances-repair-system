<?php
include 'dbconnection.php';
include 'Customer.php';
session_start();
$customer = $_SESSION['customer'];
$customerID = $customer->getCustomerID();

if (isset($_POST['btnInsertRequest'])) {

    $type = $_POST['selectType'];
    $brand = $_POST['selectBrand'];
    $description = $_POST['description'];

    // Insert the repair request into the database
    $insertSql = "INSERT INTO repairrequest (customerID, date, type, brand, description, repairStatus, deliveryStatus, paymentStatus) VALUES ('$customerID', curdate(), '$type', '$brand', '$description', 'Pending','Pending','Pending')";
    mysqli_query($conn, $insertSql);


    $sql = "SELECT repairRequestID FROM `repairrequest` ORDER BY repairRequestID DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $latestID = $row['repairRequestID'];

    // Store the image inside the repairImages folder
    $targetDir = "../repairImages/";
    $fileName = basename($_FILES["uploadImage"]["name"]);
    $targetFilePath = $targetDir . $latestID . $fileName;
    $image = $latestID . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    move_uploaded_file($_FILES["uploadImage"]["tmp_name"], $targetFilePath);

    $updateSql = "UPDATE repairrequest SET image = '$image' WHERE repairRequestID = '$latestID'";
    mysqli_query($conn, $updateSql);

    // redirect to customer_request_form.php
    echo "<script>
        window.location.href='customer_request_form.php';
        alert('Your repair request has been submitted!');
        </script>";
}

?>


<!DOCTYPE html>
<html>

<head>
    <title>Home Appliance Repair Request Form</title>
    <link rel="stylesheet" href="../css/customerStyle.css" />
    <link rel="stylesheet" href="../css/customerIndex2NavMenu.css" />
    <script src="../js/customer_form_validation.js"></script>
    <script src="https://kit.fontawesome.com/1b607b98d1.js" crossorigin="anonymous"></script>
</head>

<body>
    <header id="header_welcome">
        <div class="iconLogOut">
            <a href="customer_logout.php" onclick="return confirm('Are you sure you want to log out?')">
                <span class="icon"><i class="fa-solid fa-right-from-bracket"></i></span>
            </a>
        </div>
        <h1>Welcome To EZ Repair Customer Interface</h1>
    </header>

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

    <h1 id="h1_formName">Home Appliance Repair Request Form</h1>

    <form id="repairForm" action="" method="post" enctype="multipart/form-data" onsubmit="return validateRequestForm()">
        <label class="selectTypeLabel" for="selectType">Type:</label>
        <select id="selectType" name="selectType">
            <option value="select_type">select type</option>
            <option value="Fan">Fan</option>
            <option value="Kettle">Kettle</option>
            <option value="Oven">Oven</option>
            <option value="Iron">Iron</option>
            <option value="Blender">Blender</option>
            <option value="RiceCooker">Rice Cooker</option>
            <option value="Other">Other</option>
        </select>

        <label class="selectTypeLabel" for="selectBrand">Brand:</label>
        <select id="selectBrand" name="selectBrand">
            <option value="select_brand">select brand</option>
            <option value="Samsung">Samsung</option>
            <option value="LG">LG</option>
            <option value="Whirlpool">Whirlpool</option>
            <option value="Panasonic">Panasonic</option>
            <option value="Other">Other</option>
        </select>

        <label class="selectTypeLabel" for="description">Description:</label>
        <textarea id="description" name="description" rows="4" cols="50"></textarea>

        <div>
            <span>Upload appliance image</span>
            <br /><br>

            <input type="file" id="uploadImage" name="uploadImage" required /><br><br>
        </div>

        <p><strong>Ship your appliance to the address below:</strong></p>

        <textarea id="sendToAddress" name="sendToAddress" class="light-orange-textarea" readonly>
No. 1, Jalan Teknologi, Taman Perindustrian 31532 Malaysia</textarea>

        <div class="button-group">
            <button type="submit" class="submit-btn" name="btnInsertRequest">
                Submit
            </button>
        </div>
        <br><br>
    </form>
</body>

</html>