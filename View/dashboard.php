<main>
    <div class="topBar">
        <div class="pageTitle">Page Title</div>
        <div class="search">
            <input type="search" placeholder="search anything">
            <button>Search</button>
        </div>
    </div>
    <div class="cardBox">
        <div class="card" onclick="window.location='pregnantCows';">
            <div>
                <div class="numbers pink"><?= sizeof($pregnantCows) ?></div>
                <div class="cardName">Pregnant Cows</div>
            </div>

            <div class="iconBx">
                <img src=<?php echo $dots . './components/icons/cow.png' ?> alt="">
            </div>
        </div>

        <div class="card">
            <div>
                <div class="numbers darkred">Pending</div>
                <div class="cardName">Sick Animals</div>
            </div>

            <div class="iconBx">
                <img src=<?php echo $dots . './components/icons/temperature.png' ?> alt="">
            </div>
        </div>

        <div class="card">
            <div>
                <div class="numbers warning">Pending</div>
                <div class="cardName">Low-Yield Cows</div>
            </div>

            <div class="iconBx">
                <img src=<?php echo $dots . './components/icons/low.png' ?> alt="">
            </div>
        </div>
    </div>

    <div class="smallcardbox">
        <div class="smallcard">
            <div class="milkqnt"><?= $_SESSION['todayMilk'] ?> L</div>
            <div class="text">Milk Today</div>
        </div>

        <div class="smallcard">
            <div class="milkqnt"><?= $_SESSION['todayMilk'] * 150 ?> Rs</div>
            <div class="text">Sale Price</div>
        </div>
    </div>

    <div class="chart-container">
        <canvas id="weekBarChart"></canvas>
        <span class="text-muted"><i>Weekly Milk Record</i></span>
    </div>

    <script>
        var labels = <?php echo json_encode($labels); ?>;
        var chartData = <?php echo json_encode($chartData); ?>;

        var ctx = document.getElementById('weekBarChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Milk Quantity',
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