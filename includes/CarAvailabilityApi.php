<?php

namespace CarAvailability\includes;

class CarAvailabilityApi
{
    private string $username;
    private string $password;
    private string $clientId;
    private string $secret;
    private string $baseApiUrl;
    private string $salt;

    public function __construct() {
        $options = get_option('car_availability_settings');

        $this->username = $options['username'] ?? '';
        $this->password = $options['password'] ?? '';
        $this->clientId = $options['client_id'] ?? '';
        $this->secret = $options['secret'] ?? '';
        $this->baseApiUrl = $options['api_base_url'] ?? '';
        $this->salt = '00000000';
    }

    protected function isTokenExpired(): bool
    {
        $saved_time = get_option('car_availability_token_saved_time', 0);
        $current_time = time();
        $elapsed_time = $current_time - $saved_time;

        return $elapsed_time > 24 * 60 * 60;
    }

    public function removeToken(): bool
    {
        delete_option('car_availability_token');
        delete_option('car_availability_token_saved_time');

        if (get_option('car_availability_token') === false &&
            get_option('car_availability_token_saved_time') === false)
        {
            return true;
        }

        return false;
    }

    public function getToken(): string
    {
        if (!$this->isTokenExpired()) {
            return get_option('car_availability_token', '');
        }

        $compositeKey = $this->username . $this->salt . $this->secret . $this->password . $this->salt . $this->secret . $this->clientId;
        $hash = hash("sha512", $compositeKey, true);
        $signature = base64_encode($hash);

        $response = wp_remote_request($this->baseApiUrl . '/token', array(
            'method' => 'POST',
            'headers' => array(
                'Content-Type' => 'application/x-www-form-urlencoded',
            ),
            'body' => array(
                'client_id' => $this->clientId,
                'grant_type' => 'password',
                'username' => $this->username,
                'password' => $this->password,
                'signature' => $signature,
                'salt' => $this->salt,
            ),
        ));

        $response_body = wp_remote_retrieve_body($response);
        $response_data = json_decode($response_body, true);

        if (isset($response_data['access_token'])) {
            $token = $response_data['access_token'];

            update_option('car_availability_token', $token);
            update_option('car_availability_token_saved_time', time());

            return $token;
        }

        return '';
    }

    public function getOffices(): array
    {
        $access_token = $this->getToken();

        $response = wp_remote_get($this->baseApiUrl . '/api/offices', array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $access_token,
            ),
        ));

        $response_body = wp_remote_retrieve_body($response);
        $response_data = json_decode($response_body, true);

//        $offices = array();
//
//        if (!empty($response_data)) {
//            foreach ($response_data as $office) {
//                $office_id = $office['Id'];
//                $office_url = $this->baseApiUrl . '/api/offices/' . $office_id;
//
//                $office_response = wp_remote_get($office_url, array(
//                    'headers' => array(
//                        'Authorization' => 'Bearer ' . $access_token,
//                    ),
//                ));
//
//                $office_data = json_decode(wp_remote_retrieve_body($office_response), true);
//                $offices[] = $office_data;
//            }
//        }
//
//        return $offices;

        return $response_data;
    }

    public function getCarCategories(): array
    {
        $access_token = $this->getToken();

        $response = wp_remote_get($this->baseApiUrl . '/api/carCategories', array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $access_token,
            ),
        ));

        $response_body = wp_remote_retrieve_body($response);

        return  json_decode($response_body, true);
    }

    public function checkAvailability(int $officeOutId, int $officeInId, string $dateOut, string $dateIn): array
    {
        $access_token = $this->getToken();

        $response = wp_remote_request($this->baseApiUrl . '/api/bookings/availability', array(
            'method' => 'POST',
            'headers' => array(
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type' => 'application/json',
            ),
            'body' => json_encode(array(
                "BookAsCommissioner" => true,
                "OfficeOutId" => $officeOutId ?: '24',
                "OfficeInId" => $officeInId ?: '24',
                "DateOut" => $dateOut ?: '2023-09-10T08:34:00',
                "DateIn" => $dateIn ?: '2023-09-20T08:34:00'
            )),
        ));

        $response_body = wp_remote_retrieve_body($response);

        return json_decode($response_body, true);
    }
}
