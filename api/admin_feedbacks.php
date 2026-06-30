<?php
require_once '../config/db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

try {
    // Lấy danh sách đánh giá mới nhất
    $stmt = $pdo->query('
        SELECT f.FeedbackID, f.OrderID, f.Rating, f.Comment, f.CreatedAt,
               o.TableID
        FROM feedbacks f
        LEFT JOIN Orders o ON f.OrderID = o.OrderID
        ORDER BY f.CreatedAt DESC
    ');
    $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($feedbacks);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Lỗi máy chủ', 'detail' => $e->getMessage()]);
}
?>
