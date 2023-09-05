<?php

namespace CarAvailability\includes;

class CarAvailabilityAdminSettings
{

    public function init(): void
    {
        add_action('admin_menu', array($this, 'add_admin_menu'));
    }

    public function add_admin_menu(): void
    {
        add_menu_page(
            'Car Availability Settings',
            'Car Availability',
            'manage_options',
            'car-availability-settings',
            array($this, 'settings_page'),
            'dashicons-cloud'
        );
        add_submenu_page(
            'car-availability-settings',
            'Settings',
            'Settings',
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
        $default_tab = 'credentials';
        $tab = $_GET['tab'] ?? $default_tab;

        $tabs = array(
            'credentials' => 'API Credentials',
            'email-settings' => 'Email Settings',
        );

        echo '<div class="wrap car-availability">';
        echo '<h1>Car Availability | Settings</h1>';
        echo '<p>Add necessary settings here</p>';
        echo '<h2 class="nav-tab-wrapper">';
        foreach ($tabs as $tab_key => $tab_label) {
            $active = ($tab === $tab_key) ? 'nav-tab-active' : '';
            echo '<a href="?page=car-availability-settings&tab=' . $tab_key . '" class="nav-tab ' . $active . '">' . $tab_label . '</a>';
        }
        echo '</h2>';
        echo '<form method="post">';

        switch ($tab) {
            case 'email-settings': $this->render_email_settings_tab();
                break;
            default: $this->render_credentials_tab();
                break;
        }

        echo '</form>';
        echo '</div>';
        echo '</div>';
    }

    public function test_api_page(): void
    {
        $default_tab = 'test-token';
        $tab = $_GET['tab'] ?? $default_tab;

        $tabs = array(
            'test-token' => 'Test Token',
            'test-car-categories' => 'Test Car Categories',
            'test-offices' => 'Test Offices',
            'test-check-availability' => 'Test Check Availability',
        );

        echo '<div class="wrap car-availability">';
        echo '<h1>Car Availability | Test API</h1>';
        echo '<p>Test API EP here and inspect response</p>';
        echo '<h2 class="nav-tab-wrapper">';
        foreach ($tabs as $tab_key => $tab_label) {
            $active = ($tab === $tab_key) ? 'nav-tab-active' : ''; // Check if the current tab is active
            echo '<a href="?page=car-availability-test-api&tab=' . $tab_key . '" class="nav-tab ' . $active . '">' . $tab_label . '</a>';
        }
        echo '</h2>';

        echo '<form method="post">';

        switch ($tab) {
            case 'test-car-categories': submit_button($tabs['test-car-categories'], 'primary', 'test_car_categories', false);
                break;

            case 'test-offices': submit_button($tabs['test-offices'], 'primary', 'test_offices', false);
                break;

            case 'test-check-availability': $this->render_check_availability_tab();
                break;
            default: submit_button($tabs['test-token'], 'primary', 'test_token', false);
                break;
        }

        echo '</form>';
        echo '</div>';

        if (isset($_POST['test_check_availability'])) {
            $response = (new CarAvailabilityApi())
                ->checkAvailability(
                    $_POST['office_out'],
                    $_POST['office_in'],
                    $_POST['date_out'],
                    $_POST['date_in']
                );
        }

        if (isset($_POST['test_token'])) {
            (new CarAvailabilityApi())->removeToken();
            $response = (new CarAvailabilityApi())->getToken();
        }
        if (isset($_POST['test_car_categories'])) {
            $response = (new CarAvailabilityApi())->getCarCategories();
        }
        if (isset($_POST['test_offices'])) {
            $response = (new CarAvailabilityApi())->getOffices();
        }

        echo '<div class="wrap car-availability"><h2 class="nav-tab-wrapper">';
        if (empty($response)) {
            echo '<textarea rows="15" cols="50" style="width: 100%;" readonly>Last response: ' . get_option('car_availability_api_response') . '</textarea>';
        } else {
            $this->display_response($response);
        }
        echo '</div>';
    }

    public function render_check_availability_tab(): void
    {
        echo '<div style="display: flex; align-items: center;">
                                <input type="text" name="office_out" placeholder="Office Out Id"
                                       style="margin-right: 10px;">
                                <input type="text" name="office_in" placeholder="Office In Id"
                                       style="margin-right: 10px;">
                                <input type="datetime-local" name="date_out" style="margin-right: 10px;">
                                <input type="datetime-local" name="date_in" style="margin-right: 10px;">
                                '. submit_button('Test Check Availability', 'primary', 'test_check_availability', false);
    }

    public function render_credentials_tab(): void
    {
        $credentials = get_option('car_availability_settings');

        $fields = array(
            'username' => 'Username',
            'password' => 'Password',
            'client_id' => 'Client Id',
            'secret' => 'Secret',
            'api_base_url' => 'API Url',
        );

        foreach ($fields as $field => $label) {
            $value = isset($credentials[$field]) ? esc_attr($credentials[$field]) : '';
            $inputType = ($field === 'password' || $field === 'secret') ? 'password' : 'text';
            ?>
            <div>
                <label for="<?= $field ?>-input"><?= $label ?></label>
                <input type="<?= $inputType ?>" id="<?= $field ?>-input"
                       name="car_availability_settings[<?= $field ?>]" value="<?= $value ?>" class="regular-text">
                <?php if ($inputType === 'password') { ?>
                    <label class="show-input-value">
                        <input type="checkbox" class="show-password-checkbox" data-target="<?= $field ?>-input"> Show
                    </label>
                <?php } ?>
            </div>
        <?php }

        ?>
        <input type="submit" name="save_credentials" class="button button-primary" value="Save Changes">
        <?php

        if (isset($_POST['save_credentials'])) {
            update_option('car_availability_settings', $_POST['car_availability_settings']);
            echo '<div class="updated"><p>Settings saved.</p></div>';
        }
    }

    public function render_email_settings_tab(): void
    {
        $credentials = get_option('car_availability_settings_email');

        $fields = array(
            'email' => 'Email'
        );

        foreach ($fields as $field => $label) {
            $value = isset($credentials[$field]) ? esc_attr($credentials[$field]) : '';
            $inputType = ($field === 'password' || $field === 'secret') ? 'password' : 'text';
            ?>
            <div>
                <label for="<?= $field ?>-input"><?= $label ?></label>
                <input type="<?= $inputType ?>" id="<?= $field ?>-input"
                       name="car_availability_settings_email[<?= $field ?>]" value="<?= $value ?>" class="regular-text">
                <?php if ($inputType === 'password') { ?>
                    <label class="show-input-value">
                        <input type="checkbox" class="show-password-checkbox" data-target="<?= $field ?>-input"> Show
                    </label>
                <?php } ?>
            </div>
        <?php }

        ?>
        <input type="submit" name="save_email_settings" class="button button-primary" value="Save Changes">
        <?php

        if (isset($_POST['save_email_settings'])) {
            update_option('car_availability_settings_email', $_POST['car_availability_settings_email']);
            echo '<div class="updated"><p>Settings saved.</p></div>';
        }
    }

    public function display_response($response): void
    {
        if (!empty($response)) {
            update_option('car_availability_api_response', print_r($response, true));
            echo '<textarea rows="15" cols="50" style="width: 100%;" readonly>Last response: ' . print_r($response, true) . '</textarea>';
        }
    }
}
