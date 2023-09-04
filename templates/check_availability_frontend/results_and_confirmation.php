<form method="post">
    <div style="background-color: white">
        <p>Location Out: <?php echo $this->office_out; ?></p>
        <p>Location In: <?php echo $this->office_in; ?></p>
        <p>Date Out: <?php echo $this->date_out; ?></p>
        <p>Date In: <?php echo $this->date_in; ?></p>
        <p>Selected Car: <span id="review-selected-car"></span></p>
        <p>Selected Car Amount: <span id="review-selected-car-amount"></span></p>
        <p>Additional Driver: <span id="review-additional-driver"></span></p>
        <p>Baby Seat: <span id="review-baby-seat"></span></p>
        <p>First Name: <span id="review-first-name"></span></p>
        <p>Last Name: <span id="review-last-name"></span></p>
    </div>
    <div id="step2" class="step" style="display: block;">
        <h2>Step 2: Choose a Car</h2>
        <div id="car-list">
            <?php foreach ($cars as $car) : ?>
                <div class="car">
                    <p><?php echo $car['ModelName']; ?> - <?php echo $car['Amount']; ?></p>
                    <button type="button" onclick="selectCar('<?php echo $car['ModelName']; ?>', '<?php echo $car['Amount']; ?>')">Choose</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div id="step3" class="step" style="display: none;">
        <h2>Step 3: Choose Rental Options</h2>

        <input type="text" name="additional_driver" placeholder="Additional Driver">
        <input type="text" name="baby_seat" placeholder="Baby Seat">
        <button type="button" onclick="prevStep('step2')">Back</button>
        <button type="button" onclick="nextStep('step4')">Next</button>
    </div>

    <div id="step4" class="step" style="display: none;">
        <h2>Step 4: Personal Information</h2>
            <input type="text" name="first_name" placeholder="First Name">
            <input type="text" name="last_name" placeholder="Last Name">
            <button type="button" onclick="prevStep('step3')">Back</button>
            <button type="button" onclick="nextStep('step5')">Next</button>
    </div>

    <div id="step5" class="step" style="display: none;">
        <h2>Step 5: Review and Submit</h2>
        <div id="review-info">
            <p>Location Out: <?php echo $this->office_out; ?></p>
            <p>Location In: <?php echo $this->office_in; ?></p>
            <p>Date Out: <?php echo $this->date_out; ?></p>
            <p>Date In: <?php echo $this->date_in; ?></p>
            <p>Selected Car: <span id="review-selected-car"></span></p>
            <p>Selected Car Amount: <span id="review-selected-car-amount"></span></p>
            <p>Additional Driver: <span id="review-additional-driver"></span></p>
            <p>Baby Seat: <span id="review-baby-seat"></span></p>
            <p>First Name: <span id="review-first-name"></span></p>
            <p>Last Name: <span id="review-last-name"></span></p>

            <button type="button" onclick="prevStep('step4')">Back</button>
            <button type="submit" name="result_confirmation_form">Submit</button>
        </div>
    </div>
</form>
