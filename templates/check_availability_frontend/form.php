<div class="step">
    <h2>Check Availability</h2>
    <form method="post">
        <label for="office_in">Office In:</label>
        <select name="office_in" id="office_in">
            <?php
            foreach ($offices as $office) {
                echo '<option value="' . $office['Id'] . '">' . $office['Name'] . '</option>';
            }
            ?>
        </select>
        <br>
        <label for="office_out">Office Out:</label>
        <select name="office_out" id="office_out">
            <?php
            foreach ($offices as $office) {
                echo '<option value="' . $office['Id'] . '">' . $office['Name'] . '</option>';
            }
            ?>
        </select>
        <br>
        <label for="date_out">Date Out:</label>
        <input type="date" name="date_out" id="date_out">
        <br>
        <label for="date_in">Date In:</label>
        <input type="date" name="date_in" id="date_in">
        <br>
        <button type="submit" name="check_availability_submit">Search</button>
    </form>
</div>
