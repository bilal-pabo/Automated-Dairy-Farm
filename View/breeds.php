<main>
    <h1>Breeds</h1>
    <div class="cardBox">
        <?php for ($i = 0; $i < sizeof($breeds); $i++) { ?>
        <div class="card" onclick="window.location='';">
            <div>
                <div class="numbers darkred"><?= $breeds[$i] ?></div>
                <div class="cardName">Counts (pending)</div>
            </div>

        </div> <?php } ?>
    </div>   

</main>