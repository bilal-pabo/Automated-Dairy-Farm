<main>
    <div class="titles">Groups</div>

    <?php
    for ($i = 0; $i < sizeof($breeds); $i++) { ?>
        <div class="breed">
            <div class="titles"> <?= $breeds[$i] ?> </div>
            <div class="cows">
                <?php 
                for ($i = 0; $i < sizeof($cows); $i++)
                {
                
                } ?>
            </div>
        </div> <?php
    }
    ?>

</main>