<div class="results">
    <h2>Available Cars:</h2>
    <ul>
        <?php foreach ($cars as $car_info) : ?>
            <li><?php echo $car_info[0] ?> - <?php echo $car_info[1] ?></li>
        <?php endforeach; ?>
    </ul>
</div>
