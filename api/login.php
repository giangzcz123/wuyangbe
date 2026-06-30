<?php
require_once '../config/db.php';

// --- PHẦN FIX CORS ---
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// QUAN TRỌNG: Xử lý request OPTIONS của trình duyệt
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit; // Dừng lại ở đây, không chạy xuống logic đăng nhập bên dưới
}
// ---------------------

header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents('php://input'), true);

// Kiểm tra khớp Key với React gửi sang (UserName và PassWord)
if (!isset($data['UserName']) || !isset($data['PassWord'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Vui lòng nhập đầy đủ tài khoản và mật khẩu'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $stmt = $pdo->prepare('SELECT UserID, Username, PasswordHash, FullName, UserRole FROM Users WHERE Username = ?');
    $stmt->execute([$data['UserName']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($data['PassWord'], $user['PasswordHash'])) {
        // Xác thực thành công
        unset($user['PasswordHash']); 
        echo json_encode(['success' => true, 'user' => $user], JSON_UNESCAPED_UNICODE);
    } else {
        // Xác thực thất bại
        http_response_code(401);
        echo json_encode(['success' => false, 'error' => 'Sai tài khoản hoặc mật khẩu'], JSON_UNESCAPED_UNICODE);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Lỗi kết nối cơ sở dữ liệu'], JSON_UNESCAPED_UNICODE);
}
?>