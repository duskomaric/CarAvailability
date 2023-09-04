<?php

namespace CarAvailability\includes;

class CarAvailabilityCarCategories {

    public function init(): void
    {
        add_shortcode('car_availability_car_categories_render', array($this, 'render_frontend_car_categories'));
    }

    public function render_frontend_car_categories(): void
    {
        $cars =  (new CarAvailabilityApi())->getCarCategories();

        include(plugin_dir_path(__FILE__) . '../templates/car_categories.php');
    }
}
