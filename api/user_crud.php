<?php
require_once '../config/db.php';

header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");


// 3. Cho phép các Header cụ thể (Bắt buộc phải có Content-Type để gửi JSON)
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Xử lý Preflight request cho trình duyệt
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit; }

$method = $_SERVER['REQUEST_METHOD'];
// Đọc dữ liệu JSON từ input cho tất cả các method
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        try {
            $stmt = $pdo->prepare('SELECT UserID, Username, FullName, UserRole FROM users');
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($users, JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to fetch users'], JSON_UNESCAPED_UNICODE);
        }
        break;

    case 'POST':
        // Kiểm tra dữ liệu đầy đủ
        if (!isset($input['Username'], $input['Password'], $input['FullName'], $input['UserRole'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request data'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        try {
            $passwordHash = password_hash($input['Password'], PASSWORD_BCRYPT);
            $stmt = $pdo->prepare('INSERT INTO Users (Username, PasswordHash, FullName, UserRole) VALUES (?, ?, ?, ?)');
            $stmt->execute([
                $input['Username'],
                $passwordHash,
                $input['FullName'],
                $input['UserRole']
            ]);
            echo json_encode(['success' => true, 'UserID' => $pdo->lastInsertId()], JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to add user: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
        }
        break;

    case 'PUT':
        // Dùng $input thay vì parse_str
        if (!isset($input['UserID'])) {
            http_response_code(400);
            echo json_encode(['error' => 'UserID is required'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        try {
            $fields = [];
            $params = [];
            // Kiểm tra từng trường để build câu lệnh SQL động
            $updatableFields = ['Username', 'FullName', 'UserRole'];
            foreach ($updatableFields as $field) {
                if (isset($input[$field])) {
                    $fields[] = "$field = ?";
                    $params[] = $input[$field];
                }
            }
            // Riêng Password cần hash
            if (isset($input['Password'])) {
                $fields[] = 'PasswordHash = ?';
                $params[] = password_hash($input['Password'], PASSWORD_BCRYPT);
            }

            if (empty($fields)) {
                echo json_encode(['error' => 'No fields to update'], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $params[] = $input['UserID'];
            $stmt = $pdo->prepare('UPDATE Users SET ' . implode(', ', $fields) . ' WHERE UserID = ?');
            $stmt->execute($params);

            echo json_encode(['success' => true], JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Update failed'], JSON_UNESCAPED_UNICODE);
        }
        break;

    case 'DELETE':
        // Dùng $input cho DELETE luôn cho đồng bộ
        $id = $input['UserID'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'UserID is required'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        try {
            $stmt = $pdo->prepare('DELETE FROM users WHERE UserID = ?');
            $stmt->execute([$id]);
            echo json_encode(['success' => true], JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Delete failed'], JSON_UNESCAPED_UNICODE);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed'], JSON_UNESCAPED_UNICODE);
        break;
}


