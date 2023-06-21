<main>
    <h1>All Animals</h1>

    <div class="animalTable">
        
        <table>
            <thead>
            <tr>
                <th>No.</th>
                <th>Animal Id</th>
                <th>Breed</th>
                <th>Gender</th>
                <th>Color</th>
                <th>Date of Birth</th>
                <th>Price (PKR)</th>
            </tr>
            </thead>
            <tbody>
            <?php
            for ($i = 0; $i < sizeof($records); $i++) {
                ?>
                
                <tr onclick="window.location='animalProfile';">
                    <td><?= $i+1 ?></td>
                    <td><?= $records[$i]->id ?></td>
                    <td><?= $records[$i]->breed ?></td>
                    <td><?= $records[$i]->gender ?></td>
                    <td><?php if ($records[$i]->color) echo $records[$i]->color; else echo '---' ?></td>
                    <td><?php if ($records[$i]->dob == date('0001-01-01')) echo '---'; else echo $records[$i]->dob ?></td>
                    <td><?php if ($records[$i]->price == -1) echo '---'; else echo $records[$i]->price ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>

</main>