<?php
require_once '../config/db.php';

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!is_array($data) || empty($data['table_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request data'], JSON_UNESCAPED_UNICODE);
    exit;
}

$tableId = (int) $data['table_id'];

$message = "Khách bàn {$tableId} yêu cầu thanh toán.";

try {
    $stmt = $pdo->prepare(
        "INSERT INTO notifications (TableID, Message, Type, CreatedAt)
         VALUES (:TableID, :Message, :Type, NOW())"
    );
    $stmt->execute([
        ':TableID' => $tableId,
        ':Message' => $message,
        ':Type'    => 'checkout_request',
    ]);

    echo json_encode(['success' => true], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(
        ['error' => 'Failed to create checkout request'],
        JSON_UNESCAPED_UNICODE
    );
}