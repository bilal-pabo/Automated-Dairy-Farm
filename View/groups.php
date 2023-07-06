<main>
    <div class="titles">Groups</div>
    <?php
    if ($groupA["code"] == true) {
        $dataA = $groupA["data"];
        for ($i = 0; $i < sizeof($dataA); $i++) {
            $cowA[] = $dataA[$i]["cowid"];
            $avgA[] = $dataA[$i]["average"];
        }
        $sizeA = sizeof($dataA);
    } else {
        $sizeA = 0;
    }

    if ($groupB["code"] == true) {
        $dataB = $groupB["data"];
        for ($i = 0; $i < sizeof($dataB); $i++) {
            $cowB[] = $dataB[$i]["cowid"];
            $avgB[] = $dataB[$i]["average"];
        }
        $sizeB = sizeof($dataB);
    } else {
        $sizeB = 0;
    }

    if ($groupC["code"] == true) {
        $dataC = $groupC["data"];
        for ($i = 0; $i < sizeof($dataC); $i++) {
            $cowC[] = $dataC[$i]["cowid"];
            $avgC[] = $dataC[$i]["average"];
        }
        $sizeC = sizeof($dataC);
    } else {
        $sizeC = 0;
    }
    ?>

    <div class="group">
        <div class="groupName">Group A (10 to 25 Liters)</div>
        <div></div>
        <div class="cowList">
            <ul>
                <?php
                for ($i = 0; $i < $sizeA; $i++) {
                    ?>
                    <li> <?= $cowA[$i] ?> </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <div class="graph">
            <canvas id="groupAChart"></canvas>
        </div>
    </div>

    <script>
        var labels = <?php echo json_encode($cowA); ?>;
        var chartData = <?php echo json_encode($avgA); ?>;
        var ctx = document.getElementById('groupAChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Average (Liters)',
                    data: chartData,
                    backgroundColor: '#FF6F00',
                    barThickness: 20,
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

    <div class="group">
        <div class="groupName">Group B (25 to 35 Liters)</div>
        <div></div>
        <div class="cowList">
            <ul>
                <?php
                for ($i = 0; $i < $sizeB; $i++) {
                    ?>
                    <li> <?= $cowB[$i] ?> </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <div class="graph">
            <canvas id="groupBChart"></canvas>
        </div>
    </div>

    <script>
        var labels = <?php echo json_encode($cowB); ?>;
        var chartData = <?php echo json_encode($avgB); ?>;
        var ctx = document.getElementById('groupBChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Average (Liters)',
                    data: chartData,
                    backgroundColor: '#004D40',
                    barThickness: 20,
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

    <div class="group">
        <div class="groupName">Group C (35 to 45 Liters)</div>
        <div></div>
        <div class="cowList">
            <ul>
                <?php
                for ($i = 0; $i < $sizeC; $i++) {
                    ?>
                    <li> <?= $cowC[$i] ?> </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <div class="graph">
            <canvas id="groupCChart"></canvas>
        </div>
    </div>

    <script>
        var labels = <?php echo json_encode($cowC); ?>;
        var chartData = <?php echo json_encode($avgC); ?>;
        var ctx = document.getElementById('groupCChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Average (Liters)',
                    data: chartData,
                    backgroundColor: '#263238',
                    barThickness: 20,
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