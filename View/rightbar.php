<div class="right">


    <div class="top">

        <button id="menu-btn">

            <span class="material-icons-sharp">menu</span>

        </button>

        <div class="theme-toggler">

            <span class="material-icons-sharp active">light_mode</span>

            <span class="material-icons-sharp">dark_mode</span>

        </div>

        <div class="profile">

            <div class="info">

                <p>Hey, <b><?= $_SESSION['user']->fullname ?></b></p> <small class="text-muted">Admin</small>

            </div>

            <div class="profile-photo">
                <?php
                if ($_SESSION['user']->email == 'farwa@gmail.com') {
                    ?> <a href="profile"><img src=<?php echo $dots . 'components/profiles/admin.jpg' ?>></a> <?php
                } else {
                    ?> <a href="profile"><img src=<?php echo $dots . 'components/profiles/admin.jpg' ?>></a> <?php
                }
                ?>
            </div>

        </div>

    </div>
    <div class="add-milk" onclick="window.location='addMilkRecord'">

        <span class="material-icons-sharp">add</span>
        <h3>Add Milk Record</h3>
    </div>
    <div class="addDailyExpense">
        <h3>Daily Farm Expense</h3>
        <input type="date" id="expensedate" name="expenseDate" required>
        <div>
            <input type="number" id="dailyexpense" name="dailyExpense" placeholder="Expenses (Rs)" required>
            <button id="expenseButton" name="addExpense">Add</button>
        </div>
        <span id="expenseMsg"></span>

    </div>

    <?php
    if (isset($_SESSION['location'])) {
        if ($_SESSION['location'] == 'breeds') { ?>

            <div class="add-milk" onclick="window.location=''">

                <span class="material-icons-sharp">add</span>
                <h3>Add New Category</h3>
            </div> <?php }
    }
    unset($_SESSION['location']); ?>
</div>

<script>

    function Add_expenses(event) {

        var expensedate = $("#expensedate").val();
        var dailyexpense = $("#dailyexpense").val();
        var msg = document.getElementById("expenseMsg");
        if (!expensedate || !dailyexpense) {
            msg.innerText = "Both fields required";
            return;
        }


        var formdata = new FormData();
        formdata.append("expenseDate", expensedate);
        formdata.append("dailyExpense", dailyexpense);

        $.ajax({
            url: './expense',
            contentType: false,
            processData: false,
            data: formdata,
            type: "POST",
            success: (message) => {
                var Msg = JSON.parse(message);
                msg.innerText = Msg.message;
            },
            error: (message) => {
                var Msg = JSON.parse(message);
                msg.innerText = Msg.message;
            }
        });
    }


    $(document).ready(() => {
        $("#expenseButton").on("click", event => {
            Add_expenses(event);
        })
    });
</script>