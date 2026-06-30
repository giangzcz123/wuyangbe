<?php
require_once '../config/db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=utf-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

$tableId = isset($_GET['id']) ? intval($_GET['id']) : null;
$status = isset($_GET['status']) ? intval($_GET['status']) : null;

if ($tableId === null || $status === null) {
    http_response_code(400);
    echo json_encode(['error' => 'TableID and status are required']);
    exit;
}

try {
    $stmt = $pdo->prepare('UPDATE tables SET Status = ? WHERE TableID = ?');
    $stmt->execute([$status, $tableId]);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to update table status', 'message' => $e->getMessage()]);
}
?>
