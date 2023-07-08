<main>
    <div class="titles">Reports</div>

<!-- Daily reports -->

    <div class="duration">Daily Reports</div>

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