<?php
require_once '../config/db.php';

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

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
    echo json_encode(['error' => 'Invalid JSON body']);
    exit;
}

// FE đang gửi { table_id, token, type }
$tableId = $data['table_id'] ?? null;
$type    = $data['type']    ?? null;

if (!$tableId || !$type) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request data'], JSON_UNESCAPED_UNICODE);
    exit;
}

// Tùy biến nội dung message theo type
switch ($type) {
    case 'Thêm đá':
        $message = "Khách bàn {$tableId} yêu cầu thêm đá.";
        break;
    case 'Khăn lạnh':
        $message = "Khách bàn {$tableId} yêu cầu thêm khăn lạnh.";
        break;
    case 'Gọi nhân viên':
        $message = "Khách bàn {$tableId} yêu cầu gặp nhân viên.";
        break;
    default:
        $message = "Khách bàn {$tableId} gửi yêu cầu dịch vụ: {$type}.";
        break;
}

try {
    $stmt = $pdo->prepare(
        "INSERT INTO notifications (TableID, Message, Type, CreatedAt)
         VALUES (:TableID, :Message, :Type, NOW())"
    );
    $stmt->execute([
        ':TableID' => $tableId,
        ':Message' => $message,
        ':Type'    => 'service_request',
    ]);

    // Có thể phát socket tại đây nếu bạn dùng Socket.io / Pusher...
    // socket_emit('service_request', ['TableID' => $tableId, 'Message' => $message]);

    echo json_encode(
        ['success' => true, 'message' => 'Service request sent'],
        JSON_UNESCAPED_UNICODE
    );
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(
        ['error' => 'Failed to send service request'],
        JSON_UNESCAPED_UNICODE
    );
}// Giang update
