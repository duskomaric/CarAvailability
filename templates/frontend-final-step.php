<div class="step">
    <h2>Step 4: Enter Personal Information</h2>
    <p>Location In: <?php echo $this->location_in; ?></p>
    <p>Location Out: <?php echo $this->location_out; ?></p>
    <p>Date In: <?php echo $this->date_in; ?></p>
    <p>Date Out: <?php echo $this->date_out; ?></p>
    <p>Selected Car: <?php echo $this->selected_car; ?></p>
    <p>Additional Driver: <?php echo $this->additional_driver; ?></p>
    <p>Baby Seat: <?php echo $this->baby_seat; ?></p>

    <form method="post">

        <input type="hidden" name="location_in" value="<?php echo $this->location_in; ?>">
        <input type="hidden" name="location_out" value="<?php echo $this->location_out; ?>">
        <input type="hidden" name="date_in" value="<?php echo $this->date_in; ?>">
        <input type="hidden" name="date_out" value="<?php echo $this->date_out; ?>">
        <input type="hidden" name="selected_car" value="<?php echo $this->selected_car; ?>">
        <input type="hidden" name="additional_driver" value="<?php echo $this->additional_driver; ?>">
        <input type="hidden" name="baby_seat" value="<?php echo $this->baby_seat; ?>">

        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" required>
        <br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" required>
        <br>
        <button type="submit" name="step4_back">Back</button>
        <button type="submit" name="step4_submit">Submit</button>
    </form>
</div>
