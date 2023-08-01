<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Staff Login</title>
    <link rel="stylesheet" href="../css/staffEachPage.css" />
</head>

<body id="staff_loginPage">
    <div class="emp-login">
        <!-- staff login form -->
        <h1>Staff Login</h1>
        <form action="" method="POST">
            <p>Username</p>
            <input type="text" name="username" placeholder="Username" required />
            <p>Password</p>
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit" name="submit">Login</button>
        </form>
        <form action="../html/customer_index.html" id="formGoBack">
            <button type="submit">Cancel</button>
        </form>
    </div>
</body>

</html>

<?php
include 'dbconnection.php';
include 'Staff.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $rawPassword = $_POST['password'];
    $query = "SELECT password FROM staff WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $hashed_pass = $row["password"];

    // check if password is correct
    if (password_verify($rawPassword, $hashed_pass) == true) {

        session_start();
        $query = "SELECT * FROM staff WHERE username = '$username'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $staffID = $row['staffID'];
        $name = $row['name'];
        $phoneNumber = $row['phoneNumber'];



        $staff = new Staff($staffID, $name, $phoneNumber);
        $_SESSION['staff'] = $staff;

        header('Location: staff_repairRequest.php');
    } else {

        // if username or password is incorrect, display error message and redirect back to staff_login.php
        echo "<script>
        window.location.href='staff_login.php';
        alert('INCORRECT USERNAME OR PASSWORD!');
        </script>";
    }


    $conn->close();
}

?>