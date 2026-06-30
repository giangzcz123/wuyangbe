<?php
require_once '../config/db.php';

header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$tableId = isset($_GET['table_id']) ? $_GET['table_id'] : null;
$token = isset($_GET['token']) ? $_GET['token'] : null;

if (!$tableId || !$token) {
    echo json_encode(['valid' => false, 'force_close' => true, 'error' => 'Missing parameter']);
    exit;
}

try {
    // Tìm bàn dựa trên ID
    $stmt = $pdo->prepare('SELECT Token, Status FROM Tables WHERE TableID = ?');
    $stmt->execute([$tableId]);
    $table = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$table) {
         echo json_encode(['valid' => false, 'force_close' => true, 'error' => 'Table not found']);
         exit;
    }

    // Logic kiểm tra Token có khớp hay không
    // Nếu token trả về từ Database là rỗng (đã bị xóa do thu ngân ấn Thanh Toán)
    // Hoặc Token khác với token khách gửi lên thì trả về valid = false
    if (empty($table['Token']) || $table['Token'] !== $token) {
         echo json_encode(['valid' => false, 'force_close' => true, 'message' => 'Token expried or invalid']);
         exit;
    }

    // Bàn đang ở trạng thái 0 (Trống) hoặc 3 (Đang dọn) cũng bị coi là hết hiệu lực gọi món
    if ($table['Status'] == 0 || $table['Status'] == 3) {
         echo json_encode(['valid' => false, 'force_close' => true, 'message' => 'Table closed']);
         exit;
    }

    // Nếu mọi điều kiện đều OK
    echo json_encode(['valid' => true, 'force_close' => false]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['valid' => false, 'force_close' => true, 'error' => $e->getMessage()]);
}
?>
