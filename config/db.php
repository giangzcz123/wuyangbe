<?php
// ===== BƯỚC 1: Xử lý Preflight OPTIONS request (QUAN TRỌNG NHẤT) =====
// Browser gửi OPTIONS trước mọi POST có Content-Type: application/json
// Phải trả lời ngay lập tức với CORS headers, không được chạy code DB
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
    header("Access-Control-Max-Age: 86400");
    http_response_code(200);
    exit(); // Dừng lại, không làm gì thêm
}

// ===== BƯỚC 2: CORS headers cho các request thông thường (GET/POST) =====
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header('Content-Type: application/json; charset=utf-8');

// 2. Thông số kết nối (XAMPP Localhost)
$host = 'db';
$port = 3306;
$dbname = 'restaurantqrmanagement';
$username = 'root';
$password = 'root';
$charset = 'utf8mb4';

// 3. Chuỗi DSN
$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";

// 4. Các tùy chọn PDO tối ưu
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Báo lỗi qua Exception
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Trả về mảng key => value
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Sử dụng chuẩn Prepared Statement của MySQL
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // Trả về lỗi định dạng JSON nếu kết nối thất bại
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed: " . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
    exit();
}
?>