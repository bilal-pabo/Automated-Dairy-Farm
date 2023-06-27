<main>
    <?php
        $currentlyPregnant = array();
        for ($i = 0; $i < sizeof($pregnantCows); $i++)
        {
            if ($pregnantCows[$i]->delivery == null && $pregnantCows[$i]->abortion == null)
            {
                $currentlyPregnant[] = $pregnantCows[$i];
            }
        }

        $recentMothers = array();
        for ($i = 0; $i < sizeof($pregnantCows); $i++)
        {
            if ($pregnantCows[$i]->delivery)
            {
                $recentMothers[] = $pregnantCows[$i];
            }
        }

        $abortions = array();
        for ($i = 0; $i < sizeof($pregnantCows); $i++)
        {
            if ($pregnantCows[$i]->abortion)
            {
                $abortions[] = $pregnantCows[$i];
            }
        }
    ?>
    <h1>Pregnant Cows</h1>
    <h2 class="subHead primary">Currently Pregnant Cows</h2>
    <div class="category">
        <?php
        for ($i = 0; $i < sizeof($currentlyPregnant); $i++) {
            ?>
            <div class="animal pregnant" onclick="redirectToProfile('<?php echo $currentlyPregnant[$i]->cowid; ?>');">
                <div>
                    <div class="cowid">#<?= $currentlyPregnant[$i]->cowid ?></div>
                    <div class="startdate">From: <?= $currentlyPregnant[$i]->startdate ?></div>
                </div>

                <div class="iconBx">
                    <img src=<?php echo $dots . './components/icons/kid.png' ?> alt="">
                </div>
            </div>
            <?php
        }
        ?>

    </div>

    <h2 class="subHead primary">Recent Mothers</h2>
    <div class="category ">
        <?php
        for ($i = 0; $i < sizeof($recentMothers); $i++) {
            ?>
            <div class="animal mother" onclick="redirectToProfile('<?php echo $recentMothers[$i]->cowid; ?>');">
                <div>
                    <div class="cowid">#<?= $recentMothers[$i]->cowid ?></div>
                    <div class="startdate">Delivery Date: <?= $recentMothers[$i]->delivery ?></div>
                </div>

            </div>
            <?php
        }
        ?>

    </div>

    <h2 class="subHead primary">Abortions</h2>
    <div class="category">
        <?php
        for ($i = 0; $i < sizeof($abortions); $i++) {
            ?>
            <div class="animal abortion" onclick="redirectToProfile('<?php echo $abortions[$i]->cowid; ?>');">
                <div>
                    <div class="cowid">#<?= $abortions[$i]->cowid ?></div>
                    <div class="startdate">Abortion Date: <?= $abortions[$i]->abortion ?></div>
                </div>
            </div>
            <?php
        }
        ?>

    </div>

</main>