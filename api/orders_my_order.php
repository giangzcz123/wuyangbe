<?php
// require_once '../config/db.php';

// // Lấy TableID từ query string
// $tableId = isset($_GET['TableID']) ? intval($_GET['TableID']) : null;
// if (!$tableId) {
//     http_response_code(400);
//     echo json_encode(['error' => 'TableID is required']);
//     exit;
// }

// try {
//     $stmt = $pdo->prepare('SELECT oi.OrderItemID, oi.ProductID, p.ProductName, oi.Quantity, oi.ItemStatus, oi.CreatedAt
//                            FROM Orders o
//                            JOIN OrderItems oi ON o.OrderID = oi.OrderID
//                            JOIN Products p ON oi.ProductID = p.ProductID
//                            WHERE o.TableID = ? AND o.Status = ?');
//     $stmt->execute([$tableId, 'Pending']);

//     $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     echo json_encode($orderItems);
// } catch (PDOException $e) {
//     http_response_code(500);
//     echo json_encode(['error' => 'Failed to fetch order items']);
// }


require_once '../config/db.php';

$tableId = isset($_GET['TableID']) ? intval($_GET['TableID']) : null;
$token   = isset($_GET['token'])   ? $_GET['token']           : null;

if (!$tableId || !$token) {
    http_response_code(400);
    echo json_encode(['error' => 'TableID and token are required']);
    exit;
}

try {
    // Xác nhận token khớp với bàn hiện tại (tránh lấy đơn cũ từ phiên trước)
    $stmtCheck = $pdo->prepare('SELECT TableID FROM Tables WHERE TableID = ? AND Token = ?');
    $stmtCheck->execute([$tableId, $token]);
    if (!$stmtCheck->fetch()) {
        echo json_encode([]); // Token không hợp lệ → trả về rỗng
        exit;
    }

    // Lấy các món của phiên hiện tại (Orders đang Pending thuộc bàn này)
    $stmt = $pdo->prepare(
        'SELECT oi.OrderItemID, oi.ProductID, p.ProductName,
                oi.Quantity, oi.PriceAtTime, oi.Note, oi.ItemStatus, oi.CreatedAt
         FROM Orders o
         JOIN OrderItems oi ON o.OrderID = oi.OrderID
         JOIN Products p    ON oi.ProductID = p.ProductID
         WHERE o.TableID = ? AND o.Status = ?
         ORDER BY oi.CreatedAt ASC'
    );
    $stmt->execute([$tableId, 'Pending']);

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch order items']);
}
?>
// Giang update
