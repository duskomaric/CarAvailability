<?php
/**
 * Plugin Name: Car Availability Plugin
 * Description: A plugin to check car availability using an external API.
 * Version: 1.3.0
 */

namespace CarAvailability;

if (!defined('WP_DEBUG') || !WP_DEBUG) {
    error_reporting(0);
    ini_set('display_errors', 0);
}

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
        add_action('wp_enqueue_scripts', array($this, 'enqueueFrontendStilesAndScripts'));
        add_action('admin_enqueue_scripts', array($this, 'enqueueAdminStylesAndScripts'));

        $frontend = new CarAvailabilityFrontend();
        $frontend->init();

        $adminSettings = new CarAvailabilityAdminSettings();
        $adminSettings->init();

        $offices = new CarAvailabilityOffices();
        $offices->init();

        $carCategories = new CarAvailabilityCarCategories();
        $carCategories->init();
    }

    public function enqueueFrontendStilesAndScripts(): void
    {
        if (has_shortcode(get_post()->post_content, 'car_availability_frontend_form_render') ||
            has_shortcode(get_post()->post_content, 'car_availability_offices_render') ||
            has_shortcode(get_post()->post_content, 'car_availability_car_categories_render'))
        {
            wp_enqueue_script('jquery');
            wp_enqueue_script('car-availability-scripts', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), null, true);
            wp_enqueue_style('car-availability-styles', plugin_dir_url(__FILE__) . 'assets/css/styles.css');
        }
    }

    public function enqueueAdminStylesAndScripts(): void
    {
        wp_enqueue_style('car-availability-styles', plugin_dir_url(__FILE__) . 'assets/css/car-availability-admin-settings-styles.css');
        wp_enqueue_script('car-availability-admin-script', plugin_dir_url(__FILE__) . 'assets/js/car-availability-admin-settings-script.js', array('jquery'), null, true);
    }
}

new CarAvailabilityPlugin();
