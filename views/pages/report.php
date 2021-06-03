<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../wwwroot/css/report.css">
    <script src="../../services/report.js" defer></script>
    <title>Report</title>
</head>
<body>
    <div class="print_report_btn">
        Print
    </div>
    <div class="report_title">
        <h2>PRMS</h2>
        <p>Police Report Management System</p>
    </div>
    <div class="report_table">
        <?php 
        echo '<p id="report_section">' . $_GET['report_section'] .'</p>';
        echo '<p id="report_date">' . $_GET['report_date'] .'</p>'; 
        ?>
        <div class="table">
            <table>
            </table>
        </div>
    </div>
</body>
</html>