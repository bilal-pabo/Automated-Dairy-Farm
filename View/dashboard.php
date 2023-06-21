<main>
    <h1>Dashboard</h1>
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

</main>