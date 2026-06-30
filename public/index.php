<?php
// Entry point cho ứng dụng
header('Content-Type: application/json; charset=utf-8');

require_once '../config/db.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Định tuyến cơ bản
if (strpos($uri, '/api/v1/menu') === 0 && $method === 'GET') {
    require_once '../api/menu.php';
} elseif (strpos($uri, '/api/v1/orders/submit') === 0 && $method === 'POST') {
    require_once '../api/orders_submit.php';
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint not found']);
}
?>