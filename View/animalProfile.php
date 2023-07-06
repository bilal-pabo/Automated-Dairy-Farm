<main>
    <h1>Animal Profile</h1>
    <h2 class="subHead primary">General Information</h2>
    <form id="profileForm">

        <div class="formitem">
            <label for="id">Animal ID :</label>
            <input type="text" name="id" value="<?= $animalInfo->id ?>" id="id" class="id" placeholder="Enter animal id"
                required readonly>
        </div>

        <div class="formitem">
            <label for="breed">Breed :</label>
            <select name="breed" id="breed" required disabled>
                <option value="">Select breed</option>
                <?php
                for ($i = 0; $i < sizeof($breeds); $i++) {
                    ?> <option value="<?= $breeds[$i] ?>" <?php if ($breeds[$i] == $animalInfo->breed)
                           echo 'selected' ?>><?php echo $breeds[$i] ?></option> <?php
                }
                ?>
            </select>
        </div>

        <div class="formitem">
            <label for="gender">Gender :</label>
            <select name="gender" id="gender" required disabled>
                <option value="">Select animal type</option>
                <option value="Cow" <?php if ($animalInfo->gender == 'Cow')
                    echo 'selected' ?>>Cow</option>
                    <option value="Bull" <?php if ($animalInfo->gender == 'Bull')
                    echo 'selected' ?>>Bull</option>
                </select>
            </div>

            <div class="formitem">
                <label for="color">Color :</label>
                <input type="text" name="color" value="<?php if ($animalInfo->color)
                    echo $animalInfo->color;
                else
                    echo null; ?>" id="color" class="color" placeholder="N/A" readonly>
        </div>

        <div class="formitem">
            <label for="dob">Date of Birth :</label>
            <input type="date" name="dob" value="<?php if ($animalInfo->dob == date('0001-01-01'))
                echo null;
            else
                echo $animalInfo->dob; ?>" id="dob" class="dob" placeholder="Select date of birth" readonly>
        </div>

        <div class="formitem">
            <label for="price">Price :</label>
            <input type="number" name="price" value="<?php if ($animalInfo->price == -1)
                echo null;
            else
                echo $animalInfo->price; ?>" id="price" class="price" placeholder="N/A" readonly>
        </div>

    </form>
    <?php
    if ($animalInfo->gender == 'Cow') { ?>
        <h2 class="subHead primary">Insemination Record</h2>
        <form id="profileForm">

            <?php if ($semInfo['code'] == false) { ?>
                <div class="formitem">
                    <label for="insemination">Type :</label>
                    <select name="insemination" id="insemination" required disabled>
                        <option value="">N/A</option>
                        <option value="Natural Insemination">Natural Insemination</option>
                        <option value="Artificial Insemination">Artificial Insemination</option>
                    </select>
                </div>
                <div class="formitem">
                    <label for="bid">Bull ID :</label>
                    <input type="text" name="bid" value="" id="bid" class="bid" placeholder="N/A" readonly>
                </div>
                <div class="formitem">
                    <label for="date">Date :</label>
                    <input type="date" name="date" value="" id="date" class="date" readonly>
                </div> <?php } else { ?>


                <div class="formitem">
                    <label for="insemination">Type :</label>
                    <select name="insemination" id="insemination" required disabled>
                        <option value="">Select insemination type</option>
                        <option value="Natural Insemination" <?php if ($semInfo['data']->type == 'Natural Insemination')
                            echo 'selected' ?>>Natural Insemination</option>
                            <option value="Artificial Insemination" <?php if ($semInfo['data']->type == 'Artificial Insemination')
                            echo 'selected' ?>>Artificial Insemination</option>
                        </select>
                    </div>
                    <div class="formitem">
                        <label for="bid">Bull ID :</label>
                        <input type="text" name="bid" value="<?= $semInfo['data']->bullid ?>" id="bid" class="bid" placeholder="N/A"
                        readonly>
                </div>
                <div class="formitem">
                    <label for="date">Date :</label>
                    <input type="date" name="date" value="<?php if ($semInfo['data']->date == date('0001-01-01'))
                        echo null;
                    else
                        echo $semInfo['data']->date; ?>" id="date" class="date" readonly>
                </div> <?php } ?>
        </form>


        <h2 class="subHead primary">Pregnancy Record</h2>
        <form id="profileForm">
            <?php if ($pregInfo['code'] == false) { ?>
                <div class="formitem">
                    <label for="startDate">From :</label>
                    <input type="date" name="startDate" value="" id="startDate" class="startDate" readonly>
                </div>

                <div class="formitem">
                    <label for="deliveryDate">Delivery :</label>
                    <input type="date" name="deliveryDate" value="" id="deliveryDate" class="deliveryDate" readonly>
                </div>

                <div class="formitem">
                    <label for="abortionDate">Abortion :</label>
                    <input type="date" name="abortionDate" value="" id="abortionDate" class="abortionDate" readonly>
                </div> <?php } else { ?>

                <div class="formitem">
                    <label for="startDate">From :</label>
                    <input type="date" name="startDate" value="<?php if ($pregInfo['data']->startdate == date('0001-01-01'))
                        echo null;
                    else
                        echo $pregInfo['data']->startdate; ?>" id="startDate" class="startDate" readonly>
                </div>

                <div class="formitem">
                    <label for="deliveryDate">Delivery :</label>
                    <input type="date" name="deliveryDate" value="<?php if ($pregInfo['data']->delivery == date('0001-01-01'))
                        echo null;
                    else
                        echo $pregInfo['data']->delivery; ?>" id="deliveryDate" class="deliveryDate" readonly>
                </div>

                <div class="formitem">
                    <label for="abortionDate">Abortion :</label>
                    <input type="date" name="abortionDate" value="<?php if ($pregInfo['data']->abortion == date('0001-01-01'))
                        echo null;
                    else
                        echo $pregInfo['data']->abortion; ?>" id="abortionDate" class="abortionDate" readonly>
                </div> <?php } ?>

        </form>

        <div class="profileChartHolder">
            <div class="profileChart">
                <canvas id="cowPerformanceChart"></canvas>
            </div>
        </div>

        <?php

        if ($response["code"] == true) {
            $performanceRecord = $response["data"];
            for ($i = 0; $i < sizeof($performanceRecord); $i++) {
                $milkData[] = $performanceRecord[$i]["milkamount"];
            }
            $size = sizeof($performanceRecord);
        } else {
            $size = 0;
        }
    }
    ?>



    <script>
        var labels = <?php echo json_encode($labels); ?>;
        var chartData = <?php echo json_encode($milkData); ?>;
        var ctx = document.getElementById('cowPerformanceChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Milk (Liters)',
                    data: chartData,
                    backgroundColor: 'blue',
                    barThickness: 20,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: "Last Seven Days' Performance",
                        font: {
                            size: 15,
                            style: 'italic'
                        },
                        align: 'end'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }

            }
        });
    </script>
</main>