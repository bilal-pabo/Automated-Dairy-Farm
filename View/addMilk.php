<main>
    <h1>Add Milk</h1>

    <div><?php if (isset($_SESSION['msg'])) {
        echo "<h4>" . $_SESSION['msg'] . "</h4>";
        unset($_SESSION['msg']);
    } ?></div>

    <form id="addmilkform" method="POST">
        <div class="header">
            <div>
                <label for="milkDate">Select Date : </label>
                <input type="date" name="milkDate" required>
            </div>
            <div>
                <label class="milkPrice" for="price">Price : </label>
                <input class="price" type="number" name="milkPrice" placeholder="Enter price" required>
            </div>
            <div>
                <label class="expenseL" for="price">Expense : </label>
                <input class="expense" type="number" name="expense" placeholder="Enter expense">
            </div>
        </div>
        <table id="addmilktable">
            <thead>
                <tr>
                    <td>No.</td>
                    <td>Cow Id</td>
                    <td>Milk Amount (ltr)</td>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < sizeof($cows); $i++) { ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= $cows[$i] ?></td>
                        <td><input type="number" name="<?= $cows[$i] ?>" placeholder="Enter milk quantity"></td>
                    </tr>

                    <?php
                }

                ?>
            </tbody>
        </table>


        <input class="button-primary" type="submit" id="addRecord" name="addRecord" value="Add">

    </form>
</main>