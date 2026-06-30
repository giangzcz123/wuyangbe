<?php
require_once '../config/db.php';

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

// Preflight CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Lấy TableID từ body của request (FE gửi table_id)
$data = json_decode(file_get_contents('php://input'), true);
$tableId = isset($data['table_id']) ? (int)$data['table_id'] : null;

if (!$tableId) {
    http_response_code(400);
    echo json_encode(['error' => 'Table ID is required'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $pdo->beginTransaction();

    // Lấy OrderID đang Pending của bàn
    $stmt = $pdo->prepare(
        'SELECT OrderID FROM orders WHERE TableID = ? AND Status = ? ORDER BY CreatedAt DESC LIMIT 1'
    );
    $stmt->execute([$tableId, 'Pending']);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        throw new Exception('No pending order found for this table');
    }

    $orderId = (int)$order['OrderID'];

    // Cập nhật trạng thái đơn hàng thành Paid
    $stmt = $pdo->prepare(
        'UPDATE Orders SET Status = ?, PaidAt = NOW() WHERE OrderID = ?'
    );
    $stmt->execute(['Paid', $orderId]);

    // Trừ nguyên liệu trong kho dựa trên Recipes
    $stmt = $pdo->prepare(
        'SELECT oi.ProductID, oi.Quantity, r.IngredientID, r.AmountRequired
         FROM orderitems oi
         JOIN Recipes r ON oi.ProductID = r.ProductID
         WHERE oi.OrderID = ?'
    );
    $stmt->execute([$orderId]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ingredientId = (int)$row['IngredientID'];
        $amountUsed   = $row['Quantity'] * $row['AmountRequired'];

        $updateStock = $pdo->prepare(
            'UPDATE Ingredients SET StockQuantity = StockQuantity - ? WHERE IngredientID = ?'
        );
        $updateStock->execute([$amountUsed, $ingredientId]);
    }

    // Đóng bàn (về trạng thái trống)
    $stmt = $pdo->prepare('UPDATE Tables SET Status = 0 WHERE TableID = ?');
    $stmt->execute([$tableId]);

    $pdo->commit();

    echo json_encode(['success' => true], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    if ($pdo && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(
        ['error' => 'Failed to confirm checkout', 'message' => $e->getMessage()],
        JSON_UNESCAPED_UNICODE
    );
}
