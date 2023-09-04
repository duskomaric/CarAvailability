<?php
/**
 * Plugin Name: Car Availability Plugin
 * Description: A plugin to check car availability using an external API.
 * Version: 1.10
 */

namespace CarAvailability;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(plugin_dir_path(__FILE__) . 'includes/CarAvailabilityFrontend.php');
require_once(plugin_dir_path(__FILE__) . 'includes/CarAvailabilityAdminSettings.php');
require_once(plugin_dir_path(__FILE__) . 'includes/CarAvailabilityOffices.php');
require_once(plugin_dir_path(__FILE__) . 'includes/CarAvailabilityCarCategories.php');
require_once(plugin_dir_path(__FILE__) . 'includes/CarAvailabilityApi.php');

use CarAvailability\includes\CarAvailabilityAdminSettings;
use CarAvailability\includes\CarAvailabilityCarCategories;
use CarAvailability\includes\CarAvailabilityFrontend;
use CarAvailability\includes\CarAvailabilityOffices;

class CarAvailabilityPlugin {

    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
        add_action('admin_enqueue_scripts', array($this, 'enqueueAdminStyles'));

        $frontend = new CarAvailabilityFrontend();
        $frontend->init();

        $adminSettings = new CarAvailabilityAdminSettings();
        $adminSettings->init();

        $offices = new CarAvailabilityOffices();
        $offices->init();

        $carCategories = new CarAvailabilityCarCategories();
        $carCategories->init();
    }

    public function enqueueScripts(): void
    {
        wp_enqueue_style('car-availability-styles', plugin_dir_url(__FILE__) . 'assets/css/styles.css');

        if (has_shortcode(get_post()->post_content, 'car_availability_frontend_form_render') ||
            has_shortcode(get_post()->post_content, 'car_availability_offices_render')) {
            wp_enqueue_script('jquery'); // Make sure jQuery is loaded
            wp_enqueue_script('car-availability-scripts', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), null, true);
        }
    }

    public function enqueueAdminStyles(): void
    {
        wp_enqueue_style('car-availability-styles', plugin_dir_url(__FILE__) . 'assets/css/car-availability-admin-settings-styles.css');
    }
}

new CarAvailabilityPlugin();