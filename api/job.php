<?php
// 1. Set Headers for JSON Output & CORS (so other sites/apps can fetch this)
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

// 2. Include your Supabase Connector
// Adjust the path if your folder structure is different
require_once '../includes/db.php'; 

// 3. Initialize Response Structure
$response = [
    'status' => 'error',
    'timestamp' => date('c'),
    'count' => 0,
    'data' => []
];

try {
    // 4. Get Query Parameters (defaults provided)
    $query    = $_GET['q'] ?? '';         // Search keyword
    $location = $_GET['l'] ?? '';         // Location
    $type     = $_GET['type'] ?? '';      // Job Type (Full-time, etc.)
    $limit    = $_GET['limit'] ?? 20;     // Max results
    
    // 5. Build the Supabase Query
    $params = [
        'select' => '*',
        'limit'  => $limit,
        'order'  => 'posted_date.desc' // Show newest jobs first
    ];

    // Apply Filters if they exist
    if (!empty($query)) {
        $params['title'] = 'ilike.*' . $query . '*';
    }
    if (!empty($location)) {
        $params['location'] = 'ilike.*' . $location . '*';
    }
    if (!empty($type)) {
        $params['job_type'] = 'eq.' . $type;
    }

    // 6. Fetch Data from Supabase
    $results = $supabase->get('jobs', $params);

    // 7. Check for Supabase Errors
    if (isset($results['code']) || isset($results['error'])) {
        throw new Exception($results['message'] ?? 'Database error');
    }

    // 8. Success Response
    $response['status'] = 'success';
    $response['count']  = count($results);
    $response['data']   = $results;
    
    // Set HTTP 200 OK
    http_response_code(200);

} catch (Exception $e) {
    // 9. Error Handling
    http_response_code(500);
    $response['message'] = $e->getMessage();
}

// 10. Output JSON
echo json_encode($response, JSON_PRETTY_PRINT);
?>