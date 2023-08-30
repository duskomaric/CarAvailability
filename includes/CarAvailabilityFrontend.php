<?php

namespace CarAvailability\includes;

class CarAvailabilityFrontend {

    private bool $submitted_step1 = false;
    private bool $submitted_step2 = false;
    private bool $submitted_step3 = false;
    private bool $submitted_step4 = false;
    private string $location_in = '';
    private string $location_out = '';
    private string $date_in = '';
    private string $date_out = '';
    private ?string $selected_car = null;
    private ?string $additional_driver = null;
    private ?string $baby_seat = null;
    private ?string $first_name = null;
    private ?string $last_name = null;

    public function init(): void
    {
        add_shortcode('car_availability_frontend', array($this, 'render_shortcode_car_availability'));
        add_action('template_redirect', array($this, 'process_form_submission'));
    }

    public function process_form_submission(): void
    {

        if (isset($_POST['step1_next'])) {
            $this->submitted_step1 = true;
            $this->location_in = sanitize_text_field($_POST['location_in']);
            $this->location_out = sanitize_text_field($_POST['location_out']);
            $this->date_in = sanitize_text_field($_POST['date_in']);
            $this->date_out = sanitize_text_field($_POST['date_out']);
        }

        if (isset($_POST['step2_choose_car'])) {
            $this->submitted_step2 = true;
            //hidden
            $this->location_in = sanitize_text_field($_POST['location_in']);
            $this->location_out = sanitize_text_field($_POST['location_out']);
            $this->date_in = sanitize_text_field($_POST['date_in']);
            $this->date_out = sanitize_text_field($_POST['date_out']);
            //hidden:end

            $this->selected_car = sanitize_text_field($_POST['selected_car']);
        }

        if (isset($_POST['step3_next'])) {
            $this->submitted_step3 = true;
            //hidden
            $this->location_in = sanitize_text_field($_POST['location_in']);
            $this->location_out = sanitize_text_field($_POST['location_out']);
            $this->date_in = sanitize_text_field($_POST['date_in']);
            $this->date_out = sanitize_text_field($_POST['date_out']);
            $this->selected_car = sanitize_text_field($_POST['selected_car']);
            //hidden:end

            $this->additional_driver = sanitize_text_field($_POST['additional_driver']);
            $this->baby_seat = sanitize_text_field($_POST['baby_seat']);
        }

        if (isset($_POST['step4_submit'])) {
            $this->submitted_step4 = true;
            //hidden
            $this->location_in = sanitize_text_field($_POST['location_in']);
            $this->location_out = sanitize_text_field($_POST['location_out']);
            $this->date_in = sanitize_text_field($_POST['date_in']);
            $this->date_out = sanitize_text_field($_POST['date_out']);
            $this->selected_car = sanitize_text_field($_POST['selected_car']);
            $this->additional_driver = sanitize_text_field($_POST['additional_driver']);
            $this->baby_seat = sanitize_text_field($_POST['baby_seat']);
            //hidden:end

            $this->first_name = sanitize_text_field($_POST['first_name']);
            $this->last_name = sanitize_text_field($_POST['last_name']);

            $this->send_email();
        }
    }

    public function render_shortcode_car_availability(): void
    {
        if ($this->submitted_step1) {
            $this->render_frontend_results();
        } elseif ($this->submitted_step2) {
            $this->render_additional_options();
        } elseif ($this->submitted_step3) {
            $this->render_final_step();
        } else {
            $this->render_frontend_form();
        }
    }

    public function render_frontend_form(): void
    {
        include(plugin_dir_path(__FILE__) . '../templates/frontend-form.php');
    }

    public function render_frontend_results(): void
    {
        $cars = $this->api_call();
        include(plugin_dir_path(__FILE__) . '../templates/frontend-results.php');
    }

    public function render_additional_options(): void
    {
        include(plugin_dir_path(__FILE__) . '../templates/frontend-additional-options.php');
    }

    public function render_final_step(): void
    {
        include(plugin_dir_path(__FILE__) . '../templates/frontend-final-step.php');
    }

    private function api_call(): array
    {
        return array(
            array('name' => 'Car 1', 'category' => 'Category A', 'reserved' => true),
            array('name' => 'Car 2', 'category' => 'Category B', 'reserved' => false),
            array('name' => 'Car 3', 'category' => 'Category C', 'reserved' => false),
        );
    }

    private function send_email(): void
    {
        $to = 'test@test.com';
        $subject = 'Car Reservation Confirmation';
        $message = "Reservation Details:\n\n";
        $message .= "Location In: $this->location_in\n";
        $message .= "Location Out: $this->location_out\n";
        $message .= "Date In: $this->date_in\n";
        $message .= "Date Out: $this->date_out\n";
        $message .= "Selected Car: $this->selected_car\n";
        $message .= "Additional Driver: $this->additional_driver\n";
        $message .= "Baby Seat: $this->baby_seat\n";
        $message .= "First Name: $this->first_name\n";
        $message .= "Last Name: $this->last_name\n";

        $headers = array('Content-Type: text/html; charset=UTF-8');

        $result = wp_mail($to, $subject, $message, $headers);

        if ($result) {
            echo "Email sent successfully.";
        } else {
            echo "Email sending failed.";
        }
    }
}
