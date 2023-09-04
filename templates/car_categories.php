<div class="step">
    <h2>Locations</h2>
    <?php
    foreach ($cars as $car) : ?>
        <div class="car">
            <p><?php echo 'Name: ' . $car['CarModel']; ?></p>
            <p><?php print_r($car); ?></p>
        </div>
    <?php endforeach; ?>
</div>
