<?php
require_once '../config/db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=utf-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Lấy báo cáo tồn kho
        try {
            $stmt = $pdo->prepare('SELECT * FROM Ingredients');
            $stmt->execute();
            $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($inventory);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to fetch inventory']);
        }
        break;

    case 'POST':
        // Nhập kho nguyên liệu
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['IngredientID'], $data['Quantity'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request data']);
            exit;
        }

        try {
            $stmt = $pdo->prepare('UPDATE Ingredients SET StockQuantity = StockQuantity + ? WHERE IngredientID = ?');
            $stmt->execute([
                $data['Quantity'],
                $data['IngredientID']
            ]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update inventory']);
        }
        break;

    case 'PUT':
        // Tạo nguyên liệu mới
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['IngredientName']) || trim($data['IngredientName']) === '') {
            http_response_code(400);
            echo json_encode(['error' => 'Tên nguyên liệu là bắt buộc']);
            exit;
        }
        try {
            $stmt = $pdo->prepare('INSERT INTO Ingredients (IngredientName, Unit, StockQuantity) VALUES (?, ?, ?)');
            $stmt->execute([
                trim($data['IngredientName']),
                $data['Unit'] ?? 'kg',
                $data['StockQuantity'] ?? 0
            ]);
            echo json_encode(['success' => true, 'IngredientID' => $pdo->lastInsertId()]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Tạo nguyên liệu thất bại', 'detail' => $e->getMessage()]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}
?>