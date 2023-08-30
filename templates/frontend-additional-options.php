<div class="step">
    <h2>Step 3: Additional Options</h2>
    <p>Location In: <?php echo $this->location_in; ?></p>
    <p>Location Out: <?php echo $this->location_out; ?></p>
    <p>Date In: <?php echo $this->date_in; ?></p>
    <p>Date Out: <?php echo $this->date_out; ?></p>
    <p>Selected Car: <?php echo $this->selected_car; ?></p>

    <form method="post">

        <input type="hidden" name="location_in" value="<?php echo $this->location_in; ?>">
        <input type="hidden" name="location_out" value="<?php echo $this->location_out; ?>">
        <input type="hidden" name="date_in" value="<?php echo $this->date_in; ?>">
        <input type="hidden" name="date_out" value="<?php echo $this->date_out; ?>">
        <input type="hidden" name="selected_car" value="<?php echo $this->selected_car; ?>">


        <label for="additional_driver">Additional driver:</label>
        <input type="text" name="additional_driver" id="additional_driver" value="">
        <br>
        <label for="baby_seat">Baby Seat 0-9 Kg:</label>
        <input type="text" name="baby_seat" id="baby_seat" value="">
        <br>
        <button type="submit" name="step3_back">Back</button>
        <button type="submit" name="step3_next">Next</button>
    </form>
</div>
