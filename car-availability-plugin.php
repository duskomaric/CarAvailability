<?php
/*
 Plugin Name: Car Availability Plugin
 Description: A plugin to check car availability using an external API.
*/

error_reporting(E_ALL);
ini_set('display_errors', 1);


use CarAvailability\includes\CarAvailabilityFrontend;
use CarAvailability\includes\CarAvailabilityAdminSettings;

function car_availability_enqueue_scripts() {
    wp_enqueue_style('car-availability-styles', plugin_dir_url(__FILE__) . 'assets/css/styles.css');

    // Enqueue scripts only when shortcode is used
    if (is_page() && has_shortcode(get_post()->post_content, 'car_availability_frontend')) {
        wp_enqueue_script('jquery'); // Make sure jQuery is loaded
        wp_enqueue_script('car-availability-scripts', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), null, true);
    }
}
add_action('wp_enqueue_scripts', 'car_availability_enqueue_scripts');

require_once(plugin_dir_path(__FILE__) . 'includes/CarAvailabilityFrontend.php');
require_once(plugin_dir_path(__FILE__) . 'includes/CarAvailabilityAdminSettings.php');


$car_availability_frontend_form = new CarAvailabilityFrontend();
$car_availability_frontend_form->init();

$car_availability_admin_settings = new CarAvailabilityAdminSettings();
$car_availability_admin_settings->init();