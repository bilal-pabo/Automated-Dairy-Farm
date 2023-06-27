<main>
    <h1>Dashboard</h1> <?php $yesterday = date('Y-m-d', strtotime('-6 day')); echo $yesterday ?>
    <div class="cardBox">
        <div class="card" onclick="window.location='pregnantCows';">
            <div>
                <div class="numbers pink"><?= sizeof($pregnantCows) ?></div>
                <div class="cardName">Pregnant Cows</div>
            </div>

            <div class="iconBx">
            <img src=<?php echo $dots.'./components/icons/cow.png' ?> alt="">
            </div>
        </div>

        <div class="card">
            <div>
                <div class="numbers darkred">Pending</div>
                <div class="cardName">Sick Animals</div>
            </div>

            <div class="iconBx">
            <img src=<?php echo $dots.'./components/icons/temperature.png' ?> alt="">
            </div>
        </div>

        <div class="card">
            <div>
                <div class="numbers warning">Pending</div>
                <div class="cardName">Low-Yield Cows</div>
            </div>

            <div class="iconBx">
            <img src=<?php echo $dots.'./components/icons/low.png' ?> alt="">
            </div>
        </div>
    </div>

    <div class="smallcardbox">
        <div class="smallcard">
            <div class="milkqnt"><?= $_SESSION['todayMilk'] ?> L</div>
            <div class="text">Milk Today</div>
        </div>
    </div>

    <canvas id="weekBarChart"></canvas>
    <script>
        var labels = <?php echo json_encode($labels); ?>;
        var chartData = <?php echo json_encode($chartData); ?>;

        // Create a bar chart
        var ctx = document.getElementById('weekBarChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Chart Data',
                    data: chartData,
                    backgroundColor: 'rgba(0, 123, 255, 0.5)',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</main>