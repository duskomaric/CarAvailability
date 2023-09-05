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

        add_submenu_page(
            'car-availability-settings',
            'Test API',
            'Test API',
            'manage_options',
            'car-availability-test-api',
            array($this, 'test_api_page')
        );
    }

    public function settings_page(): void
    {
        ?>
        <div class="wrap car-availability">
            <h1>Car Availability</h1>
            <form method="post" action="options.php">
                <?php settings_fields('car_availability_settings_group'); ?>
                <?php do_settings_sections('car-availability-settings'); ?>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    public function test_api_page(): void
    {
        ?>
        <div class="wrap car-availability">
            <h1>Car Availability</h1>
            <form method="post">
                <?php

                do_settings_sections('car-availability-test-api');

                if (isset($_POST['test_token'])) {
                    (new CarAvailabilityApi())->removeToken();
                    $response = (new CarAvailabilityApi())->getToken();
                    $this->display_response($response);
                }
                if (isset($_POST['test_car_categories'])) {
                    $response = (new CarAvailabilityApi())->getCarCategories();
                    $this->display_response($response);
                }
                if (isset($_POST['test_offices'])) {
                    $response = (new CarAvailabilityApi())->getOffices();
                    $this->display_response($response);
                }

                if (empty($response)) {
                    echo '<textarea rows="15" cols="50" style="width: 100%;" readonly>Last response: '. get_option('car_availability_api_response').'</textarea>';
                }
                ?>
            </form>
        </div>
        <?php
    }

    public function register_settings(): void
    {
        register_setting('car_availability_settings_group', 'car_availability_settings');
        register_setting('car_availability_settings_test_api_group', 'car_availability_settings');

        $fields['settings_page'] = array(
            'username' => 'API Username',
            'password' => 'API Password',
            'client_id' => 'Client Id',
            'secret' => 'Secret',
            'api_base_url' => 'API Base Url',
        );

        foreach ($fields['settings_page'] as $field => $label) {
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
            'Car Availability | API credentials',
            function(){ echo 'Enter your API credentials and endpoint below:';},
            'car-availability-settings'
        );

        $fields['test_api_page'] = array(
            'test_token' => 'Test Token',
            'test_offices' => 'Test Offices',
            'test_car_categories' => 'Test Car Categories'
        );

        foreach ($fields['test_api_page'] as $field => $label) {
            add_settings_field(
                $field,
                $label,
                array($this, 'field_callback'),
                'car-availability-test-api',
                'car_availability_test_api_section',
                array('field' => $field, 'label' => $label)
            );
        }

        add_settings_section(
            'car_availability_test_api_section',
            'Car Availability | API Test',
            function(){ echo 'Test API responses here';},
            'car-availability-test-api'
        );
    }

    public function field_callback($args): void
    {
        $options = get_option('car_availability_settings');
        $field = $args['field'];
        $label = $args['label'];
        $value = $options[$field] ?? '';

        $isPasswordField = ($field === 'password' || $field === 'secret');
        $inputType = $isPasswordField ? 'password' : 'text';
        $inputClass = $isPasswordField ? 'password-input' : '';

        $dataAttribute = $isPasswordField ? 'data-password-input' : '';

        if (in_array($field, ['test_offices', 'test_car_categories', 'test_token'])){
            submit_button($label, 'primary', $field, false);
        } else {
            echo "<input type='$inputType' id='$field-input' name='car_availability_settings[$field]' value='$value' class='$inputClass' $dataAttribute />";

            if ($isPasswordField) {
                echo "<label><input type='checkbox' class='show-password-checkbox' data-target='$field-input'> Show $label</label>";
            }
        }
    }

    public function display_response($response): void
    {
        if (!empty($response)) {
            update_option('car_availability_api_response', print_r($response, true));
            echo '<textarea rows="15" cols="50" style="width: 100%;" readonly>' . print_r($response, true) . '</textarea>';
        }
    }
}
