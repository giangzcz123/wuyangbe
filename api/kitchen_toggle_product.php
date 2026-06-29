<?php
// require_once '../config/db.php';
// header('Content-Type: application/json; charset=utf-8');
// // Lấy ID từ URL
// $productId = isset($_GET['id']) ? intval($_GET['id']) : null;
// if (!$productId) {
//     http_response_code(400);
//     echo json_encode(['error' => 'Product ID is required']);
//     exit;
// }

// try {
//     // Lấy trạng thái hiện tại của sản phẩm
//     $stmt = $pdo->prepare('SELECT IsAvailable FROM Products WHERE ProductID = ?');
//     $stmt->execute([$productId]);
//     $product = $stmt->fetch(PDO::FETCH_ASSOC);

//     if (!$product) {
//         http_response_code(404);
//         echo json_encode(['error' => 'Product not found']);
//         exit;
//     }

//     // Đảo trạng thái IsAvailable
//     $newStatus = $product['IsAvailable'] ? 0 : 1;
//     $stmt = $pdo->prepare('UPDATE Products SET IsAvailable = ? WHERE ProductID = ?');
//     $stmt->execute([$newStatus, $productId]);

//     echo json_encode(['success' => true, 'IsAvailable' => $newStatus]);
// } catch (PDOException $e) {
//     http_response_code(500);
//     echo json_encode(['error' => 'Failed to toggle product availability']);
// }
//
// header('Content-Type: application/json; charset=utf-8');
//
require_once '../config/db.php';
//
// --- THÊM CẤU HÌNH CORS Ở ĐÂY ---
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Xử lý request preflight OPTIONS của trình duyệt
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
// -------------------------------

// Lấy dữ liệu từ Body JSON
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

$productId = isset($data['ProductID']) ? intval($data['ProductID']) : null;
$isAvailable = isset($data['IsAvailable']) ? intval($data['IsAvailable']) : null;

if (!$productId || !isset($data['IsAvailable'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Product ID and IsAvailable status are required']);
    exit;
}

try {
    // Cập nhật trạng thái IsAvailable trực tiếp từ giá trị FE gửi lên
    $stmt = $pdo->prepare('UPDATE Products SET IsAvailable = ? WHERE ProductID = ?');
    $stmt->execute([$isAvailable, $productId]);
//
    echo json_encode([
        'success' => true, 
        'ProductID' => $productId,
        'IsAvailable' => $isAvailable 
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to toggle product availability', 'details' => $e->getMessage()]);
}


?>