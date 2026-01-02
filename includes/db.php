<?php
// Configuration
define('SUPABASE_URL', 'https://ykchwqtvudvbrgbprspe.supabase.co');
// Note: ideally store keys in environment variables for production
define('SUPABASE_KEY', 'sb_secret_6CDz-EeFdkgNDpCnzMqp2Q_zcpHaaQl'); 

class Supabase {
    private $url;
    private $key;

    public function __construct() {
        $this->url = SUPABASE_URL . '/rest/v1/';
        $this->key = SUPABASE_KEY;
    }

    // Fetch data from a table
    public function get($table, $params = []) {
        // Convert params to query string
        $queryString = http_build_query($params);
        $url = $this->url . $table . '?' . $queryString;
        
        return $this->request('GET', $url);
    }

    // Generic request handler (GET, POST, etc.)
    private function request($method, $url, $data = null) {
        $ch = curl_init();
        $headers = [
            'apikey: ' . $this->key,
            'Authorization: Bearer ' . $this->key,
            'Content-Type: application/json',
            'Prefer: return=representation' // Ensures Supabase returns the data after inserts/updates
        ];

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            return ['error' => $error];
        }
        
        return json_decode($response, true);
    }
}

// Initialize the connection object
$supabase = new Supabase();

// Start PHP session for Auth management
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>