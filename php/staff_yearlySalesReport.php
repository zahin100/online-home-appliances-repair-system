<?php
include 'staff_sidebarMenu.php';
include 'dbconnection.php';

// get number of repair requests, total sales for current year
$sql = "SELECT COUNT(repairRequestID) AS numRepairRequest, IFNULL(SUM(totalPrice), 0) AS totalSales FROM repairrequest WHERE YEAR(date) = YEAR(now())";
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
    <title>Yearly Sales Report</title>
    <link rel="stylesheet" href="../css/staffEachPage.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <div class="salesReportPage" id="generatePDF">
        <h2>YEARLY SALES REPORT</h2>

        <form action="staff_weeklySalesReport.php"><button type="submit" id="btnSalesReport">Weekly Sales Report</button></form>
        <form action="staff_monthlySalesReport.php"><button type="submit" id="btnSalesReport">Monthly Sales Report</button></form>

        <br><br><br>
        <!-- sales bar graph -->
        <canvas id="yearlyChart" style="width:100%;max-width:700px"></canvas>

        <br><span id="totalRepaired">Number of appliance repaired: <?php echo $numRepairRequest ?> </span><br><br>
        <span id="totalSales">Total Sales: RM <?php echo $totalSales ?></span><br>

        <br><button id="btnGeneratePDF">Download PDF</button><br><br>
    </div>

    <?php

    $month = array();

    // get sales for each month
    for ($x = 1; $x < 13; $x++) {

        $sql = "SELECT IFNULL(SUM(totalPrice), 0) AS totalSales FROM repairrequest WHERE MONTH(date) = $x AND YEAR(date) = YEAR(NOW())";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        array_push($month, $row["totalSales"]);
    }

    ?>

    <!-- JavaScript to draw bar graph -->
    <script>
        var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "July", "Aug", "Sep", "Oct", "Nov", "Dec"];
        var yValues = [<?php echo $month[0] ?>, <?php echo $month[1] ?>, <?php echo $month[2] ?>, <?php echo $month[3] ?>, <?php echo $month[4] ?>, <?php echo $month[5] ?>, <?php echo $month[6] ?>,
            <?php echo $month[7] ?>, <?php echo $month[8] ?>, <?php echo $month[9] ?>, <?php echo $month[10] ?>, <?php echo $month[11] ?>
        ];
        var barColors = ["red", "purple", "blue", "orange", "brown", "green", "magenta", "yellow", "navy", "black", "skyblue", "maroon"];
        new Chart("yearlyChart", {
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
            filename: "YearlySalesReport",

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