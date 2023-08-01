<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <script src="https://kit.fontawesome.com/1b607b98d1.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/staffSidebarMenu.css">
</head>

<body>

    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar">
        <div class="sidebar-header">
            <h3 class="brand">
                <span class="ti-unlink"></span>
                <span>EZ Repair</span>
            </h3>
            <label for="sidebar-toggle" class="ti-menu-alt"></label>
        </div>

        <!-- sidebar menu -->
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="staff_repairRequest.php">
                        <span class="icon"><i class="fa-solid fa-screwdriver-wrench"></i></span>
                        <span>Repair Request</span>
                    </a>
                </li>
                <li>
                    <a href="staff_feedback.php">
                        <span class="icon"><i class="fa-solid fa-comments"></i></span>
                        <span>Customer Feedback</span>
                    </a>
                </li>
                <li>
                    <a href="staff_inventory.php">
                        <span class="icon"><i class="fa-solid fa-box"></i></span>
                        <span>Inventory</span>
                    </a>
                </li>
                <li>
                    <a href="staff_weeklySalesReport.php">
                        <span class="icon"><i class="fa-sharp fa-solid fa-chart-simple"></i></span>
                        <span>Sales Report</span>
                    </a>
                </li>
                <li>
                    <a href="staff_logout.php" onclick="return confirm('Are you sure you want to sign out?')">
                        <span class="icon"><i class="fa-solid fa-right-from-bracket"></i></span>
                        <span>Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

    </div>

</body>

</html>