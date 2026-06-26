<?php
require_once '../config/db.php';

header('Content-Type: application/json; charset=utf-8');

// (Khuyến nghị) Bật lỗi khi dev
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Lấy ID bàn từ query string
$tableId = isset($_GET['id']) ? intval($_GET['id']) : null;
if (!$tableId) {
    http_response_code(400);
    echo json_encode(['error' => 'Table ID is required'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    // Nếu cần cập nhật Order, dùng transaction
    $pdo->beginTransaction();

    // Ví dụ: Cập nhật tất cả Order "Pending" của bàn này thành "Paid"
    // Tùy cấu trúc DB của bạn, có thể bỏ hoặc chỉnh lại đoạn này
    $stmt = $pdo->prepare(
        'UPDATE Orders SET Status = ? WHERE TableID = ? AND Status = ?'
    );
    $stmt->execute(['Paid', $tableId, 'Pending']);

    // Xóa token + chuyển bàn về trạng thái TRỐNG (0)
    $stmt = $pdo->prepare(
        'UPDATE Tables SET Status = ?, Token = NULL WHERE TableID = ?'
    );
    $stmt->execute([0, $tableId]); // 0 = Trống

    $pdo->commit();

    echo json_encode(['success' => true], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    if ($pdo && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(
        [
            'error' => 'Failed to checkout table',
            'message' => $e->getMessage(),
        ],
        JSON_UNESCAPED_UNICODE
    );
}