<div class="step">
    <h2>Locations</h2>
    <?php
    foreach ($offices as $office) : ?>
        <div class="car">
            <p><?php echo 'Name: ' . $office['Name']; ?></p>
            <p><?php echo 'Code: ' . $office['Code']; ?></p>
            <p><?php echo 'Address: ' . $office['Address']; ?></p>
            <p><?php echo 'Tel: ' . $office['Tel']; ?></p>
        </div>
    <?php endforeach; ?>
</div>
