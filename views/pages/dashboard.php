<?php 
require_once 'includes/session.php';
?>
<script src="services/dashboard.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.0/chart.min.js" defer></script>
<div class="banner_container">
    <div class="banner">
        <img src="wwwroot/vectors/banner.svg" alt="">
        <div class="texts">
            <h2>Hello <?php echo strtoupper($_SESSION['username']); ?>, Welcome Back!</h2>
            <p>Let me help you to speed up your organizing of records. <br> I arranged below the summary of some of your records.</p>
        </div>
    </div>
</div>
<div class="monthly_records">
    <h2>As of <?php echo date('M Y'); ?></h2>
    <div class="reports_chart">
        <canvas id="myChart"></canvas>
    </div>
    <div class="records">
        <div class="crime_record">
            <span>Crime Records</span>
            <div class="count">0</div>
        </div>
        <div class="lost_item_record">
            <span>Lost Item Records</span>
            <div class="count">0</div>
        </div>
        <div class="missing_person_record">
            <span>Missing Person Records</span>
            <div class="count">0</div>
        </div>
    </div>
</div>