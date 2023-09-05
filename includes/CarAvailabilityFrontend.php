<?php

namespace CarAvailability\includes;

class CarAvailabilityFrontend {

    private bool $submitted_check_availability_form = false;
    private string $office_in;
    private string $office_out;
    private string $date_in;
    private string $date_out;

    public function init(): void
    {
        add_shortcode('car_availability_frontend_form_render', array($this, 'render_shortcode_car_availability'));
        add_action('template_redirect', array($this, 'process_form_submission'));
    }

    public function process_form_submission(): void
    {
        if (isset($_POST['check_availability_submit'])) {
            if (
                !empty(sanitize_text_field($_POST['office_in'])) ||
                !empty(sanitize_text_field($_POST['office_out'])) ||
                !empty(date('Y-m-d\TH:i:s', strtotime(sanitize_text_field($_POST['date_in'])))) ||
                !empty(date('Y-m-d\TH:i:s', strtotime(sanitize_text_field($_POST['date_out']))))
            ) {
                wp_die('Something went wrong. Please try again later.', 'Error', [
                    'response' => 422,
                    'back_link' => true,
                ]);
            }
            $this->submitted_check_availability_form = true;
            $this->office_in = sanitize_text_field($_POST['office_in']);
            $this->office_out = sanitize_text_field($_POST['office_out']);
            $this->date_in = date('Y-m-d\TH:i:s', strtotime(sanitize_text_field($_POST['date_in'])));
            $this->date_out = date('Y-m-d\TH:i:s', strtotime(sanitize_text_field($_POST['date_out'])));
        }

        if (isset($_POST['result_confirmation_form'])) {
            $this->selected_car = $_POST['selected_car'];
            $this->additional_driver = sanitize_text_field($_POST['additional_driver']);
            $this->baby_seat = sanitize_text_field($_POST['baby_seat']);
            $this->first_name = sanitize_text_field($_POST['first_name']);
            $this->last_name = sanitize_text_field($_POST['last_name']);

            $this->send_email();
        }
    }

    public function render_shortcode_car_availability(): void
    {
        if ($this->submitted_check_availability_form) {
            $cars =  (new CarAvailabilityApi())->checkAvailability(intval($this->office_out), intval($this->office_in), $this->date_out, $this->date_in);
            include(plugin_dir_path(__FILE__) . '../templates/check_availability_frontend/results_and_confirmation.php');
        } else {
            $offices =  (new CarAvailabilityApi())->getOffices();
            include(plugin_dir_path(__FILE__) . '../templates/check_availability_frontend/form.php');
        }
    }

    private function send_email(): void
    {
        $to = 'test@test.com';
        $subject = 'Car Reservation Confirmation';
        $message = "Reservation Details:\n\n";
//        $message .= "Location In: $this->location_in\n";
//        $message .= "Location Out: $this->location_out\n";
//        $message .= "Date In: $this->date_in\n";
//        $message .= "Date Out: $this->date_out\n";
//        $message .= "Selected Car: $this->selected_car\n";
//        $message .= "Additional Driver: $this->additional_driver\n";
//        $message .= "Baby Seat: $this->baby_seat\n";
//        $message .= "First Name: $this->first_name\n";
//        $message .= "Last Name: $this->last_name\n";

        //dd(json_encode($this->selected_car_json));
        //dd($_POST);

        $headers = array('Content-Type: text/html; charset=UTF-8');

        $result = wp_mail($to, $subject, $message, $headers);

        if ($result) {
            echo "Email sent successfully.";
        } else {
            echo "Email sending failed.";
        }
    }
}

