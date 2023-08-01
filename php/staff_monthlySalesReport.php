<?php
include 'staff_sidebarMenu.php';
include 'dbconnection.php';

// get number of repair requests and total sales for current month
$sql = "SELECT COUNT(repairRequestID) AS numRepairRequest, IFNULL(SUM(totalPrice), 0) AS totalSales FROM repairrequest WHERE MONTH(date) = MONTH(now()) AND YEAR(date) = YEAR(now())";
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
    <title>Monthly Sales Report</title>
    <link rel="stylesheet" href="../css/staffEachPage.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <div class="salesReportPage" id="generatePDF">
        <h2>MONTHLY SALES REPORT</h2>

        <form action="staff_weeklySalesReport.php"><button type="submit" id="btnSalesReport">Weekly Sales Report</button></form>
        <form action="staff_yearlySalesReport.php"><button type="submit" id="btnSalesReport">Yearly Sales Report</button></form>

        <br><br><br>
        <!-- sales bar chart -->
        <canvas id="monthlyChart" style="width:100%;max-width:700px"></canvas>

        <br><span id="totalRepaired">Number of appliance repaired: <?php echo $numRepairRequest ?> </span><br><br>
        <span id="totalSales">Total Sales: RM <?php echo $totalSales ?></span><br>

        <br><button id="btnGeneratePDF">Download PDF</button><br><br>
    </div>

    <?php

    $week = array();

    // get sales for each week
    for ($x = 0; $x < 4; $x++) {

        $sql = "SELECT IFNULL(SUM(totalPrice), 0) AS totalSales FROM repairrequest WHERE YEARWEEK(date,1) = YEARWEEK(LAST_DAY(NOW()) - INTERVAL $x WEEK,1)";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        array_push($week, $row["totalSales"]);
    }

    ?>

    <!-- JavaScript to display bar graph -->
    <script>
        var xValues = ["Week 1", "Week 2", "Week 3", "Week 4"];
        var yValues = [<?php echo $week[3] ?>, <?php echo $week[2] ?>, <?php echo $week[1] ?>, <?php echo $week[0] ?>];
        var barColors = ["red", "purple", "blue", "orange"];
        new Chart("monthlyChart", {
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
            filename: "MonthlySalesReport",

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