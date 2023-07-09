<main>
    <div class="titles">Reports</div>

    <!-- Daily reports -->

    <div class="duration">Daily Reports</div>

    <div class="reportCards">
        <?php
        if ($dailyMilkRecords['code'] == true) {
            $data = $dailyMilkRecords['data'];
            $size = sizeof($data);
        } else
            $size = 0;

        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $itemsPerPage = 7;
        $totalItems = $size;
        $totalPages = ceil($totalItems / $itemsPerPage);

        $startIndex = ($currentPage - 1) * $itemsPerPage;
        $endIndex = $startIndex + $itemsPerPage - 1;
        if ($endIndex >= $totalItems) {
            $endIndex = $totalItems - 1;
        }
        ?>
        <div class="dailyMilkTable reportTable">
            <table>
                <thead>
                    <th>No.</th>
                    <th>Date</th>
                    <th>Milk (L)</th>
                    <th>Expense</th>
                    <th>Profit</th>
                </thead>
                <tbody>
                    <?php

                    for ($i = $startIndex; $i <= $endIndex; $i++) {
                        ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= $data[$i]["date"] ?></td>
                            <td><?= $data[$i]["amount"] ?></td>
                            <td><?= $data[$i]["expense"] ?></td>
                            <td><?= $data[$i]["saleprice"] - $data[$i]["expense"] ?></td>
                        </tr> <?php
                    }
                    ?>
                </tbody>
            </table>
            <div class="pagination">
                <?php if ($currentPage > 1): ?>
                    <a href="?page=<?php echo ($currentPage - 1); ?>">Previous</a>
                <?php endif; ?>

                <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                    <a href="?page=<?php echo $page; ?>" <?php if ($page == $currentPage)
                           echo 'class="active"'; ?>><?php echo $page; ?></a>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <a href="?page=<?php echo ($currentPage + 1); ?>">Next</a>
                <?php endif; ?>
            </div>
            <script>
                const paginationLinks = document.querySelectorAll('.pagination a');
                paginationLinks.forEach(link => {
                    link.addEventListener('click', e => {
                        e.preventDefault();
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                        const href = link.getAttribute('href');
                        window.history.pushState({}, '', href);
                        loadPage(href);
                    });
                });
                function loadPage(url) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', url);
                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            const parser = new DOMParser();
                            const newDoc = parser.parseFromString(xhr.responseText, 'text/html');
                            const bodyContent = newDoc.querySelector('body').innerHTML;
                            document.body.innerHTML = bodyContent;
                        }
                    };
                    xhr.send();
                }
            </script>
        </div>

        <div class="titles">Daily Report Chart</div>
        <div class="dailyReportChart">
            <canvas id="dailyReportChart"></canvas>
        </div>

        <script>

var labels = <?php echo json_encode($days); ?>;
var chartData = <?php echo json_encode($milkAmount); ?>;
var ctx = document.getElementById('dailyReportChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Milk (Liters)',
            data: chartData,
            borderColor: 'red',
            backgroundColor: '#FFEBEE',
            pointBackgroundColor: 'red', 
            pointRadius: 5, 
            pointHoverRadius: 7,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: "Daily Milk Production",
                font: {
                    size: 15,
                    style: 'italic',
                    weight: 'bold'
                },
                align: 'end'
            },
            legend: {
                display: false,
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    font: {
                        size: 12,
                        weight: 'bold'
                    }
                }
            },
            x: {
                display: true,
                text: 'Days', // Add the text description for x-axis labels
                title: {
                    display: true,
                    text: 'Days',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                },
                ticks: {
                    font: {
                        size: 12,
                        weight: 'bold'
                    },
                    callback: function(value, index, values) {
                        return ''; // Hide the x-axis labels
                    }
                },
                grid: {
                    display: false, // Hide the x-axis grid lines
                }
            }
        }
    }
});



        </script>

    </div>

    <!-- Weekly reports -->

    <div class="duration">Weekly Reports</div>

    <form action="/fetchReports" method="post">
        <div class="topOfReports">

            <select name="group" id="group">
                <option value="">Select Group</option>
                <option value="A">Group A</option>
                <option value="B">Group B</option>
                <option value="C">Group C</option>
            </select>

            <select name="breed" id="breed">
                <option value="">Select Breed</option>
                <?php
                for ($i = 0; $i < sizeof($breeds); $i++) {
                    echo "<option value='$breeds[$i]'>$breeds[$i]</option>";
                }
                ?>
            </select>

            <select name="cowid" id="cowid">
                <option value="">Select Cow</option>
                <?php
                for ($i = 0; $i < sizeof($cows); $i++) {
                    echo "<option value='$cows[$i]'>$cows[$i]</option>";
                }
                ?>
            </select>

            <div class="underTop">
                <input type="button" name="filter" value="Filter">
            </div>
        </div>

    </form>

    <!-- Monthly reports -->

    <div class="duration">Monthly Reports</div>

    <form action="/fetchReports" method="post">
        <div class="topOfReports">

            <select name="group" id="group">
                <option value="">Select Group</option>
                <option value="A">Group A</option>
                <option value="B">Group B</option>
                <option value="C">Group C</option>
            </select>

            <select name="breed" id="breed">
                <option value="">Select Breed</option>
                <?php
                for ($i = 0; $i < sizeof($breeds); $i++) {
                    echo "<option value='$breeds[$i]'>$breeds[$i]</option>";
                }
                ?>
            </select>

            <select name="cowid" id="cowid">
                <option value="">Select Cow</option>
                <?php
                for ($i = 0; $i < sizeof($cows); $i++) {
                    echo "<option value='$cows[$i]'>$cows[$i]</option>";
                }
                ?>
            </select>

            <div class="underTop">
                <input type="button" name="filter" value="Filter">
            </div>
        </div>

    </form>
</main>