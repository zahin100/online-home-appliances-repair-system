<?php
include 'staff_sidebarMenu.php';
include 'dbconnection.php';

// get number of repair requests and total sales for current week
$sql = "SELECT COUNT(repairRequestID) AS numRepairRequest, IFNULL(SUM(totalPrice), 0) AS totalSales FROM repairrequest WHERE YEARWEEK(date) = YEARWEEK(now())";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $numRepairRequest = $row["numRepairRequest"];
        $totalSales = $row["totalSales"];
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
    <title>Weekly Sales Report</title>
    <link rel="stylesheet" href="../css/staffEachPage.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <div class="salesReportPage" id="generatePDF">
        <h2>WEEKLY SALES REPORT</h2>

        <form action="staff_monthlySalesReport.php"><button type="submit" id="btnSalesReport">Monthly Sales Report</button></form>
        <form action="staff_yearlySalesReport.php"><button type="submit" id="btnSalesReport">Yearly Sales Report</button></form>

        <br><br><br>
        <!-- sales bar graph -->
        <canvas id="weeklyChart" style="width:100%;max-width:700px"></canvas>

        <br><span id="totalRepaired">Number of appliance repaired: <?php echo $numRepairRequest ?> </span><br><br>
        <span id="totalSales">Total Sales: RM <?php echo $totalSales ?></span><br>

        <br><button id="btnGeneratePDF">Download PDF</button><br><br>
    </div>

    <?php

    $day = array();

    // get sales for each day
    for ($x = 0; $x < 7; $x++) {

        $sql = "SELECT IFNULL(SUM(totalPrice), 0) AS totalSales FROM repairrequest WHERE WEEKDAY(date) = $x AND YEARWEEK(date) = YEARWEEK(now())";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        array_push($day, $row["totalSales"]);
    }

    ?>

    <!-- JavaScript to draw bar graph -->
    <script>
        var xValues = [" Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
        var yValues = [<?php echo $day[0] ?>, <?php echo $day[1] ?>, <?php echo $day[2] ?>, <?php echo $day[3] ?>, <?php echo $day[4] ?>, <?php echo $day[5] ?>, <?php echo $day[6] ?>];
        var barColors = ["red", "purple", "blue", "orange", "brown", "green", "magenta"];
        new Chart("weeklyChart", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                legend: {
                    display: false
                }
            }
        });
    </script>

    <script>
        const button = document.getElementById('btnGeneratePDF');
        var opt = {
            margin: 1,
            filename: "WeeklySalesReport",

            html2canvas: {
                scale: 2,
                height: 750,
                dpi: 192,
                letterRendering: true
            },
            jsPDF: {
                unit: "mm",
                format: [500, 600],
                orientation: "portrait"
            }
        };

        function generatePDF() {
            // Choose the element that your content will be rendered to.
            const element = document.getElementById('generatePDF');
            // Choose the element and save the PDF for your user.
            html2pdf().set(opt).from(element).save();
        }

        button.addEventListener('click', generatePDF);
    </script>
</body>

</html>