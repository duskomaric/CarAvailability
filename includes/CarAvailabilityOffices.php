<?php

namespace CarAvailability\includes;

class CarAvailabilityOffices {

    public function init(): void
    {
        add_shortcode('car_availability_offices_render', array($this, 'render_frontend_offices'));
    }

    public function render_frontend_offices(): void
    {
        $offices =  (new CarAvailabilityApi())->getOffices();

        include(plugin_dir_path(__FILE__) . '../templates/offices.php');
    }
}
