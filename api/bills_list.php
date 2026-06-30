<?php
require_once '../config/db.php';
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");

try {
    // 1. Phải cộng dồn từ bảng OrderItems do Order có thể lưu TotalAmount = 0
    // 2. Lấy cả hóa đơn ở trạng thái Completed, Pending, và Paid
    $sql = "SELECT o.OrderID, o.TableID, t.TableNumber, o.Status, o.CreatedAt,
            (
                SELECT IFNULL(SUM(oi.Quantity * IFNULL(oi.PriceAtTime, p.Price)), 0)
                FROM OrderItems oi
                JOIN Products p ON oi.ProductID = p.ProductID
                WHERE oi.OrderID = o.OrderID
            ) as TotalAmount
            FROM Orders o
            LEFT JOIN Tables t ON o.TableID = t.TableID
            WHERE o.Status IN ('Completed', 'Pending', 'Paid') 
            ORDER BY o.CreatedAt DESC";
            
    $stmt = $pdo->query($sql);
    $bills = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($bills);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
