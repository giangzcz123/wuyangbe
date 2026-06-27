<?php
require_once '../config/db.php';

header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Bật lỗi khi DEV
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Xử lý preflight CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Lấy dữ liệu từ body của request
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON body', 'raw' => $raw]);
    exit;
}

if (!isset($data['TableID']) || !isset($data['Items']) || !is_array($data['Items'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request data', 'data' => $data]);
    exit;
}

try {
    $pdo->beginTransaction();

    // Tạo đơn hàng mới
    $stmt = $pdo->prepare('INSERT INTO Orders (TableID, Status) VALUES (?, ?)');
    $stmt->execute([$data['TableID'], 'Pending']);
    $orderId = $pdo->lastInsertId();

    // Thêm các món vào OrderItems, bao gồm cả cột Note
    // LƯU Ý: Phải đảm bảo DB bảng OrderItems của bạn đã có cột Note
    $stmt = $pdo->prepare(
        'INSERT INTO OrderItems (OrderID, ProductID, Quantity, PriceAtTime, Note) 
         VALUES (?, ?, ?, ?, ?)'
    );

    foreach ($data['Items'] as $item) {
        if (!isset($item['ProductID'], $item['Quantity'], $item['PriceAtTime'])) {
            throw new Exception('Invalid item data: ' . json_encode($item));
        }
        
        // Lấy ghi chú món ăn, nếu không có thì gán mặc định là NULL (hoặc rỗng)
        $note = isset($item['Note']) ? $item['Note'] : null;

        $stmt->execute([
            $orderId,
            $item['ProductID'],
            $item['Quantity'],
            $item['PriceAtTime'],
            $note // Thêm biến $note vào execute
        ]);
    }

    $pdo->commit();

    echo json_encode(['success' => true, 'OrderID' => $orderId]);
} catch (Exception $e) {
    if ($pdo && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode([
        'error'   => 'Failed to submit order',
        'message' => $e->getMessage()
    ]);
}
// Giang update
//session_start();
// Fix bug: Chặn khách hàng spam click liên tục tạo nhiều đơn trùng nhau
//if (isset($_SESSION['last_order_time']) && (time() - $_SESSION['last_order_time'] < 5)) {
    //echo json_encode(["status" => "error", "message" => "Vui lòng đợi 5 giây trước khi đặt món tiếp theo."]);
    //exit();
//}
//$_SESSION['last_order_time'] = time();
