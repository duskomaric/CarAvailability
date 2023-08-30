<?php

namespace CarAvailability\includes;

class CarAvailabilityFrontendForm {
    public function init() {
        add_action('init', array($this, 'add_form_action'));
    }

    public function add_form_action() {
        if (isset($_POST['car_availability_submit'])) {
            $this->render_frontend_results();
        }
    }

    public function render_frontend_form() {
        include(plugin_dir_path(__FILE__) . '../templates/frontend-form.php');
    }

    public function render_frontend_results() {
        $cars = $this->api_call();
        include(plugin_dir_path(__FILE__) . '../templates/frontend-results.php');
    }

    private function api_call() {
        return array(
            array('Car 1', 'Category A', true),
            array('Car 2', 'Category B', false),
            array('Car 3', 'Category C', true),
        );
    }
}

