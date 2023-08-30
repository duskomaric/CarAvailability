<?php

namespace CarAvailability\includes;

class CarAvailabilityLocationsFrontend {

    public function init(): void
    {
        add_shortcode('car_availability_locations_frontend', array($this, 'render_frontend_locations'));
    }

    public function render_frontend_locations(): void
    {
        $locations = $this->api_call();
        include(plugin_dir_path(__FILE__) . '../templates/frontend-locations.php');
    }

    private function api_call(): array
    {
        return array(
            array('name' => 'Location 1'),
            array('name' => 'Location 2')
        );
    }
}
