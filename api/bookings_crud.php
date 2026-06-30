<?php
require_once '../config/db.php';

// Các header CORS đã được khai báo ở db.php
$method = $_SERVER['REQUEST_METHOD'];

// Handle preflight OPTIONS request
if ($method == 'OPTIONS') {
    exit;
}

try {
    switch ($method) {
        case 'GET':
            // Lấy danh sách Booking dành cho Thu ngân (Cashier)
            // Hỗ trợ lọc theo trạng thái, ngày, hoặc tìm kiếm (tên, sđt)
            $status = $_GET['status'] ?? '';
            $date = $_GET['date'] ?? '';
            $search = $_GET['search'] ?? '';

            $query = "SELECT * FROM bookings WHERE 1=1";
            $params = [];

            if ($status) {
                // Nếu status = 'All', không gắn điều kiện
                if ($status !== 'All') {
                    $query .= " AND Status = ?";
                    $params[] = $status;
                }
            }

            if ($date) {
                $query .= " AND BookingDate = ?";
                $params[] = $date;
            }

            if ($search) {
                $query .= " AND (CustomerName LIKE ? OR CustomerPhone LIKE ?)";
                $params[] = "%$search%";
                $params[] = "%$search%";
            }

            $query .= " ORDER BY BookingDate ASC, BookingTime ASC";

            $stmt = $pdo->prepare($query);
            $stmt->execute($params);
            
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            break;

        case 'POST':
            // Tạo mới đơn đặt bàn (từ khách hàng)
            $data = json_decode(file_get_contents("php://input"), true);

            // Validate required fields
            $required = ['CustomerName', 'CustomerPhone', 'BranchName', 'BookingDate', 'BookingTime', 'GuestCount'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    throw new Exception("Thiếu trường $field");
                }
            }

            $stmt = $pdo->prepare("INSERT INTO bookings (CustomerName, CustomerPhone, BranchName, BookingDate, BookingTime, GuestCount, Note, Status) VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')");
            
            $stmt->execute([
                $data['CustomerName'],
                $data['CustomerPhone'],
                $data['BranchName'],
                $data['BookingDate'],
                $data['BookingTime'],
                $data['GuestCount'],
                $data['Note'] ?? null
            ]);

            echo json_encode(['success' => true, 'BookingID' => $pdo->lastInsertId()]);
            break;

        case 'PUT':
        case 'PATCH':
            // Cập nhật trạng thái đổi đơn đặt bàn (Bởi Cashier)
            $data = json_decode(file_get_contents("php://input"), true);

            if (empty($data['BookingID']) || empty($data['Status'])) {
                throw new Exception("Thiếu BookingID hoặc Status để cập nhật");
            }

            // Hợp lệ hóa các trạng thái
            $validStatuses = ['Pending', 'Confirmed', 'Cancelled', 'Arrived'];
            if (!in_array($data['Status'], $validStatuses)) {
                throw new Exception("Trạng thái không hợp lệ");
            }

            $stmt = $pdo->prepare("UPDATE bookings SET Status = ? WHERE BookingID = ?");
            $stmt->execute([$data['Status'], $data['BookingID']]);

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
