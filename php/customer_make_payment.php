<?php
include 'dbconnection.php';
$repairRequestID = $_GET['repairRequestID'];
$customerAddress = $_GET['address'];

if (isset($_POST['btnConfirmPayment'])) {

    $addressOption = $_POST['addressOption'];
    $alternateAddress = $_POST['alternateAddressText'];
    $address = "";

    // check whether customer selected current address or alternative address
    if ($addressOption == "currentAddress") {
        $address = $customerAddress;
    } else {
        $address = $alternateAddress;
    }

    // Store the receipt inside the paymentFile folder
    $targetDir = "../paymentFile/";
    $fileName = basename($_FILES["receiptFile"]["name"]);
    $targetFilePath = $targetDir . $repairRequestID . $fileName;
    $paymentFile = $repairRequestID . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    move_uploaded_file($_FILES["receiptFile"]["tmp_name"], $targetFilePath);

    // update data in the database
    $updateSql = "UPDATE repairrequest SET paymentFile = '$paymentFile', shippingAddress = '$address', paymentStatus = 'Completed' WHERE repairRequestID = '$repairRequestID'";
    mysqli_query($conn, $updateSql);

    // redirect to customer_payment.php page
    echo "<script>
    window.location.href='customer_payment.php';
    alert('Your payment is successful!');
    </script>";
}
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

    <!-- Payment form -->
    <div id="formMakePayment">
        <form onsubmit="return validatePayment()" method="post" enctype="multipart/form-data">
            <h2 id="h2_payment">Complete Your Payment</h2>

            <p><strong>Shipping address</strong></p>

            <div>
                <input type="radio" id="currentAddress" name="addressOption" value="currentAddress" checked onclick="manageTextArea()" />
                <label for="currentAddress">Use current address</label>
            </div>

            <div>
                <input type="radio" id="alternateAddress" name="addressOption" value="alternateAddress" onclick="manageTextArea()" />
                <label for="alternateAddress">Use alternate address</label>
            </div>

            <p><strong>Alternate address</strong></p>

            <textarea id="alternateAddressText" name="alternateAddressText" readonly></textarea>

            <p><strong>Make payment to:</strong></p>

            <textarea id="makePaymentTo" name="makePaymentTo" class="light-orange-textarea" readonly>XYZ Bank
            
  01114446226732</textarea>

            <p><strong>Upload receipt</strong></p>
            <input type="file" id="receiptFile" name="receiptFile" /><br /><br />

            <div class="button-container-payment">
                <button type="submit" name="btnConfirmPayment">
                    Confirm Payment
                </button>
            </div>
        </form>
        <form action="customer_payment.php">
            <button type="submit" class="cancel-button">Cancel</button>
        </form>
    </div>

    <!-- enable or disable text area based on address radio button input -->
    <script>
        function manageTextArea() {

            var addressTextArea = document.getElementById("alternateAddressText");
            var shippingOption = document.querySelector('input[name="addressOption"]:checked').value;

            if (shippingOption == "currentAddress") {
                addressTextArea.readOnly = true;
                addressTextArea.style.opacity = "0.5";
                addressTextArea.value = "";
            } else {
                addressTextArea.readOnly = false;
                addressTextArea.style.opacity = "1.0";
                addressTextArea.focus();
            }
        }
    </script>
</body>

</html>