<?php
require_once '../config/db.php';
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
//
//
//
try {
    // Lấy toàn bộ danh sách danh mục và sản phẩm (không lọc IsAvailable)
    $stmt = $pdo->query("SELECT * FROM Categories ORDER BY CategoryID ASC");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = [];
    foreach ($categories as $cat) {
        $stmtProd = $pdo->prepare("SELECT * FROM Products WHERE CategoryID = ?");
        $stmtProd->execute([$cat['CategoryID']]);
        $cat['Products'] = $stmtProd->fetchAll(PDO::FETCH_ASSOC);
        $result[] = $cat;
    }

    echo json_encode($result);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>