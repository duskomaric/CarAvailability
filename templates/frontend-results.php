<div class="step">
    <h2>Step 2: Available Cars</h2>
    <p>Location In: <?php echo $this->location_in; ?></p>
    <p>Location Out: <?php echo $this->location_out; ?></p>
    <p>Date In: <?php echo $this->date_in; ?></p>
    <p>Date Out: <?php echo $this->date_out; ?></p>

    <?php foreach ($cars as $car) : ?>
        <?php if ($car['reserved'] === false) : ?>
            <div class="car">
                <p><?php echo $car['name']; ?> - <?php echo $car['category']; ?></p>
                <form method="post">

                    <input type="hidden" name="location_in" value="<?php echo $this->location_in; ?>">
                    <input type="hidden" name="location_out" value="<?php echo $this->location_out; ?>">
                    <input type="hidden" name="date_in" value="<?php echo $this->date_in; ?>">
                    <input type="hidden" name="date_out" value="<?php echo $this->date_out; ?>">

                    <input type="hidden" name="selected_car" value="<?php echo $car['name']; ?>">
                    <button type="submit" name="step2_choose_car">Choose</button>
                </form>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <form method="post">
        <button type="submit" name="step2_back">Back</button>
    </form>
</div>
