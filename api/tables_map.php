<?php
// require_once '../config/db.php';

// try {
//     $stmt = $pdo->prepare('SELECT TableID, TableNumber, Status FROM Tables');
//     $stmt->execute();

//     $tables = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     echo json_encode($tables);
// } catch (PDOException $e) {
//     http_response_code(500);
//     echo json_encode(['error' => 'Failed to fetch table map']);
// }

require_once '../config/db.php';
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");

try {
    // Câu truy vấn lấy danh sách bàn kèm theo tổng tiền tạm tính của các món đang xử lý
    $sql = "SELECT t.*, 
            (
                SELECT IFNULL(SUM(oi.Quantity * oi.PriceAtTime), 0)
                FROM Orders o
                JOIN OrderItems oi ON o.OrderID = oi.OrderID
                WHERE o.TableID = t.TableID 
                  AND o.Status = 'Pending'
            ) AS TotalAmount
            FROM Tables t
            ORDER BY t.TableID ASC";
            
    $stmt = $pdo->query($sql);
    $tables = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($tables);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}


?>
// Refactor: Toi uu truy van trang thai ban de load nhanh hon
