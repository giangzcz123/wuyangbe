<?php
require_once '../config/db.php';

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

// Preflight CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Lấy TableID từ query string ?table_id=...
$tableId = isset($_GET['table_id']) ? intval($_GET['table_id']) : null;
if (!$tableId) {
    http_response_code(400);
    echo json_encode(['error' => 'Table ID is required'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $stmt = $pdo->prepare(
        'SELECT oi.Quantity, oi.PriceAtTime
         FROM orders o
         JOIN orderitems oi ON o.OrderID = oi.OrderID
         WHERE o.TableID = ? AND o.Status = ?'
    );
    $stmt->execute([$tableId, 'Pending']);

    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $subtotal = 0;
    foreach ($items as $item) {
        $subtotal += $item['Quantity'] * $item['PriceAtTime'];
    }

    $vat = $subtotal * 0.10;      // 10% VAT
    $serviceFee = $subtotal * 0.05; // 5% phí dịch vụ
    $total = $subtotal + $vat + $serviceFee;

    echo json_encode([
        'subtotal'     => $subtotal,
        'vat'          => $vat,
        'service_fee'  => $serviceFee,
        'total'        => $total,
    ], JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to calculate checkout'], JSON_UNESCAPED_UNICODE);
}
