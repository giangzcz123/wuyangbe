<?php
require_once '../config/db.php';
header("Content-Type: application/json; charset=utf-8");

try {
    // 1. Kiểm tra xem có Order nào đang 'Pending' không
    $stmt = $pdo->query("SELECT OrderID, TableID, Status FROM orders WHERE Status = 'Pending'");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // 2. Kiểm tra chi tiết món ăn của tất cả đơn hàng Pending
    $stmt2 = $pdo->query("
        SELECT oi.OrderID, p.ProductName, oi.Quantity, p.Price 
        FROM orderitems oi 
        JOIN products p ON oi.ProductID = p.ProductID
        JOIN Orders o ON oi.OrderID = o.OrderID
        WHERE o.Status = 'Pending'
    ");
    $items = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'pending_orders_count' => count($orders),
        'pending_orders' => $orders,
        'items_found' => $items
    ], JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
