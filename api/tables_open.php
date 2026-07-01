<?php
require_once '../config/db.php';

header('Content-Type: application/json; charset=utf-8');

// Lấy ID từ URL
$tableId = isset($_GET['id']) ? intval($_GET['id']) : null;
if (!$tableId) {
    http_response_code(400);
    echo json_encode(['error' => 'Table ID is required'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    // Kiểm tra xem bàn đã được mở chưa
    $stmt = $pdo->prepare('SELECT Status FROM tables WHERE TableID = ?');
    $stmt->execute([$tableId]);
    $table = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$table) {
        http_response_code(404);
        echo json_encode(['error' => 'Table not found'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($table['Status'] != 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Table is already in use'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Mở bàn và tạo Order mới
    $pdo->beginTransaction();

    $stmt = $pdo->prepare('UPDATE tables SET Status = ? WHERE TableID = ?');
    $stmt->execute([1, $tableId]);

    $stmt = $pdo->prepare('INSERT INTO orders (TableID, Status) VALUES (?, ?)');
    $stmt->execute([$tableId, 'Pending']);
    $orderId = $pdo->lastInsertId();

    // Tạo token duy nhất cho link gọi món
    $token = bin2hex(random_bytes(16));
    $stmt = $pdo->prepare('UPDATE tables SET Token = ? WHERE TableID = ?');
    $stmt->execute([$token, $tableId]);

    $pdo->commit();

    // $orderLink = "http://localhost:8088/hadilaoPHP/api/order.php?table_id={$tableId}&token={$token}";
    // ===== CHỌN 1 TRONG 3 TÙY CHỌN BÊN DƯỚI =====
    // 1. Chạy local (chỉ mình anh xem trên máy):
    // $orderLink = "http://localhost:5173/customer-menu?table_id={$tableId}&token={$token}";
    
    // ✅ ĐANG DÙNG: Demo tại lớp (điện thoại cùng Wi-Fi quét được)
    // FE chạy trên Windows (192.168.2.3), BE chạy trên Ubuntu (192.168.2.18)
    $orderLink = "http://192.168.2.3:5173/customer-menu?table_id={$tableId}&token={$token}";
    
    echo json_encode(['success' => true, 'OrderID' => $orderId, 'OrderLink' => $orderLink], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    if ($pdo && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode([
        'error'   => 'Failed to open table',
        'message' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>
