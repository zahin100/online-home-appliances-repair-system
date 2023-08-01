<?php
include 'staff_sidebarMenu.php';
include 'connect.php';

// Fetch feedback data
$sql = 'SELECT f.feedbackID, c.name, f.star, f.description FROM feedback f INNER JOIN customer c ON f.customerID = c.customerID';
$result = mysqli_query($connection, $sql);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <script src="https://kit.fontawesome.com/1b607b98d1.js" crossorigin="anonymous"></script>
    <title>Customer Feedback</title>
    <link rel="stylesheet" href="../css/staffSidebarMenu.css">
    <link rel="stylesheet" href="../css/staffFeedback.css">
</head>

<body>
    <div id="main-content" class="content">
        <h1>Customer Feedback</h1>
        <div id="container">

            <!-- display feedback from the customers -->
            <div class="feedback-list">
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <div class="feedback-card">
                        <h2><?php echo $row['name']; ?></h2>
                        <p><?php echo $row['description']; ?></p>
                        <div class="star-rating">
                            <span class="rating"><?php echo $row['star']; ?></span> &#9733;
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>

</html>