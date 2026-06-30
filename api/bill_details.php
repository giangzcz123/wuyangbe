<?php
require_once '../config/db.php';
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");

// Lấy OrderID từ Frontend gửi lên
$orderId = isset($_GET['OrderID']) ? intval($_GET['OrderID']) : null;

if (!$orderId) {
    http_response_code(400);
    echo json_encode(['error' => 'Vui lòng cung cấp OrderID']);
    exit;
}

try {
    // Lấy chi tiết món ăn (Quantity) kết hợp với bảng Products để lấy Tên và Giá
    $sql = "SELECT oi.OrderItemID, oi.OrderID, oi.ProductID, oi.Quantity, 
                   IFNULL(oi.PriceAtTime, p.Price) as PriceAtTime, 
                   p.ProductName, p.Price, oi.Note, oi.ItemStatus
            FROM orderitems oi
            JOIN products p ON oi.ProductID = p.ProductID
            WHERE oi.OrderID = ?";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$orderId]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Luôn trả về mảng, nếu không có món nào trả về mảng rỗng []
    echo json_encode($items);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
