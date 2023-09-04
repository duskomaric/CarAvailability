<?php
namespace CarAvailability\includes;

class CarAvailabilityAdminSettings {
    public function init(): void
    {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function add_admin_menu(): void
    {
        add_menu_page(
            'Car Availability Settings',
            'Car Availability',
            'manage_options',
            'car-availability-settings',
            array($this, 'settings_page')
        );
    }

    public function settings_page(): void
    {
        ?>
        <div class="wrap car-availability">
            <h1>Car Availability Plugin Settings</h1>
            <form method="post" action="options.php">
                <?php settings_fields('car_availability_settings_group'); ?>
                <?php do_settings_sections('car-availability-settings'); ?>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    public function register_settings(): void
    {
        register_setting('car_availability_settings_group', 'car_availability_settings');

        $fields = array(
            'username' => 'API Username',
            'password' => 'API Password',
            'client_id' => 'Client Id',
            'secret' => 'Secret',
            'api_base_url' => 'API Base Url',
        );

        foreach ($fields as $field => $label) {
            add_settings_field(
                $field,
                $label,
                array($this, 'field_callback'),
                'car-availability-settings',
                'car_availability_section',
                array('field' => $field)
            );
        }

        add_settings_section(
            'car_availability_section',
            'Car Availability API Settings',
            array($this, 'section_callback'),
            'car-availability-settings'
        );
    }

    public function section_callback(): void
    {
        echo '<p>Enter your API credentials and endpoint below:</p>';
    }

    public function field_callback($args): void
    {
        $options = get_option('car_availability_settings');
        $field = $args['field'];
        $value = $options[$field] ?? '';

        $input_type = ($field === 'password' || $field === 'secret') ? 'password' : 'text';

        echo "<input type='$input_type' name='car_availability_settings[$field]' value='$value' />";
    }
}
