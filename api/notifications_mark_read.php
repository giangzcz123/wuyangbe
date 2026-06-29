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

if (!is_array($data) || empty($data['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request data'], JSON_UNESCAPED_UNICODE);
    exit;
}

$id = (int) $data['id'];

try {
    $stmt = $pdo->prepare(
        "UPDATE notifications SET IsRead = 1 WHERE NotificationID = :id"
    );
    $stmt->execute([':id' => $id]);

    echo json_encode(['success' => true], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(
        ['error' => 'Failed to update notification'],
        JSON_UNESCAPED_UNICODE
    );
}