<?php
require_once('../config/db.php');
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
//
//
try {
    $stmt = $pdo->prepare(
        "SELECT oi.OrderItemID, oi.ProductID, p.ProductName, 
                oi.Quantity, oi.PriceAtTime, oi.Note, oi.ItemStatus,
                o.TableID, t.TableNumber
         FROM OrderItems oi
         JOIN Orders o ON oi.OrderID = o.OrderID
         JOIN Products p ON oi.ProductID = p.ProductID
         LEFT JOIN Tables t ON o.TableID = t.TableID
         WHERE oi.ItemStatus IN ('Waiting', 'Cooking') AND o.Status = 'Pending'
         ORDER BY oi.CreatedAt ASC"
    );
    $stmt->execute();
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
//
?>