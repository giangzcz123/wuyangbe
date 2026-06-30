<?php
require_once '../config/db.php';
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'OPTIONS') {
    exit;
}

try {
    switch ($method) {
        case 'GET':
            // Lấy danh sách bàn
            $stmt = $pdo->query("SELECT * FROM tables ORDER BY TableID ASC");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            break;

        case 'POST':
            // Thêm bàn mới
            $data = json_decode(file_get_contents("php://input"), true);
            if (empty($data['TableNumber'])) {
                throw new Exception("Số bàn không được để trống");
            }
            $stmt = $pdo->prepare("INSERT INTO Tables (TableNumber, Status) VALUES (?, ?)");
            $stmt->execute([$data['TableNumber'], $data['Status'] ?? 'Available']);
            echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
            break;

        case 'PUT':
            // Cập nhật thông tin bàn
            $data = json_decode(file_get_contents("php://input"), true);
            if (empty($data['TableID']) || empty($data['TableNumber'])) {
                throw new Exception("Thiếu thông tin cập nhật bàn");
            }
            $stmt = $pdo->prepare("UPDATE Tables SET TableNumber = ?, Status = ? WHERE TableID = ?");
            $stmt->execute([$data['TableNumber'], $data['Status'], $data['TableID']]);
            echo json_encode(['success' => true]);
            break;

        case 'DELETE':
            // Xóa bàn
            $data = json_decode(file_get_contents("php://input"), true);
            if (empty($data['TableID'])) {
                throw new Exception("Thiếu ID bàn để xóa");
            }
            // Kiểm tra xem bàn có đang có Order Pending không
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE TableID = ? AND Status = 'Pending'");
            $stmt->execute([$data['TableID']]);
            if ($stmt->fetchColumn() > 0) {
                throw new Exception("Không thể xóa bàn đang có đơn hàng chưa thanh toán");
            }

            $stmt = $pdo->prepare("DELETE FROM tables WHERE TableID = ?");
            $stmt->execute([$data['TableID']]);
            echo json_encode(['success' => true]);
            break;

        default:
            http_response_code(405);
            echo json_encode(['error' => 'Method Not Allowed']);
            break;
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
