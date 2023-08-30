<?php
namespace CarAvailability\includes;

class CarAvailabilityAdminSettings {
    public function init() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function add_admin_menu() {
        add_menu_page(
            'Car Availability Settings',
            'Car Availability',
            'manage_options',
            'car-availability-settings',
            array($this, 'settings_page')
        );
    }

    public function settings_page() {
        ?>
        <div class="wrap">
            <h1>Car Availability Plugin Settings</h1>
            <form method="post" action="options.php">
                <?php settings_fields('car_availability_settings_group'); ?>
                <?php do_settings_sections('car-availability-settings'); ?>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    public function register_settings() {
        register_setting('car_availability_settings_group', 'car_availability_settings');

        add_settings_section(
            'car_availability_section',
            'Car Availability API Settings',
            array($this, 'section_callback'),
            'car-availability-settings'
        );

        add_settings_field(
            'username',
            'API Username',
            array($this, 'username_field_callback'),
            'car-availability-settings',
            'car_availability_section'
        );

        add_settings_field(
            'password',
            'API Password',
            array($this, 'password_field_callback'),
            'car-availability-settings',
            'car_availability_section'
        );

        add_settings_field(
            'api_endpoint',
            'API Endpoint',
            array($this, 'api_endpoint_field_callback'),
            'car-availability-settings',
            'car_availability_section'
        );
    }

    public function section_callback() {
        echo '<p>Enter your API credentials and endpoint below:</p>';
    }

    public function username_field_callback() {
        $options = get_option('car_availability_settings');
        $username = isset($options['username']) ? $options['username'] : '';
        echo "<input type='text' name='car_availability_settings[username]' value='$username' />";
    }

    public function password_field_callback() {
        $options = get_option('car_availability_settings');
        $password = isset($options['password']) ? $options['password'] : '';
        echo "<input type='password' name='car_availability_settings[password]' value='$password' />";
    }

    public function api_endpoint_field_callback() {
        $options = get_option('car_availability_settings');
        $api_endpoint = isset($options['api_endpoint']) ? $options['api_endpoint'] : '';
        echo "<input type='text' name='car_availability_settings[api_endpoint]' value='$api_endpoint' />";
    }
}
