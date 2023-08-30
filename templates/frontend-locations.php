<div class="step">
    <h2>Locations</h2>

    <?php foreach ($locations as $location) : ?>
            <div class="car">
                <p><?php echo $location['name']; ?></p>
            </div>
    <?php endforeach; ?>
</div>