<?php
/**
 * Plugin Name: Car Availability Plugin
 * Description: A plugin to check car availability using an external API.
 * Version: 1.10
*/

error_reporting(E_ALL);
ini_set('display_errors', 1);

use CarAvailability\includes\CarAvailabilityCarCategories;
use CarAvailability\includes\CarAvailabilityFrontend;
use CarAvailability\includes\CarAvailabilityAdminSettings;
use CarAvailability\includes\CarAvailabilityOffices;

function car_availability_enqueue_scripts(): void
{
    wp_enqueue_style('car-availability-styles', plugin_dir_url(__FILE__) . 'assets/css/styles.css');

    if (has_shortcode(get_post()->post_content, 'car_availability_frontend_form_render') ||
        has_shortcode(get_post()->post_content, 'car_availability_offices_render')) {
        wp_enqueue_script('jquery'); // Make sure jQuery is loaded
        wp_enqueue_script('car-availability-scripts', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), null, true);
    }

}
add_action('wp_enqueue_scripts', 'car_availability_enqueue_scripts');

function enqueue_custom_styles(): void
{
    wp_enqueue_style('car-availability-styles', plugin_dir_url(__FILE__) . 'assets/css/car-availability-admin-settings-styles.css');
}
add_action('admin_enqueue_scripts', 'enqueue_custom_styles');

require_once(plugin_dir_path(__FILE__) . 'includes/CarAvailabilityFrontend.php');
require_once(plugin_dir_path(__FILE__) . 'includes/CarAvailabilityAdminSettings.php');
require_once(plugin_dir_path(__FILE__) . 'includes/CarAvailabilityOffices.php');
require_once(plugin_dir_path(__FILE__) . 'includes/CarAvailabilityCarCategories.php');
require_once(plugin_dir_path(__FILE__) . 'includes/CarAvailabilityApi.php');
require_once(plugin_dir_path(__FILE__) . 'cpt/Location_CPT.php');


$car_availability_frontend_form = new CarAvailabilityFrontend();
$car_availability_frontend_form->init();

$car_availability_admin_settings = new CarAvailabilityAdminSettings();
$car_availability_admin_settings->init();

$car_availability_offices = new CarAvailabilityOffices();
$car_availability_offices->init();

$car_availability_car_categories = new CarAvailabilityCarCategories();
$car_availability_car_categories->init();

