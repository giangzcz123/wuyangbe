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
        // Lấy danh sách món ăn
        try {
            $stmt = $pdo->prepare('SELECT * FROM products');
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($products);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to fetch products']);
        }
        break;

    case 'POST':
        // Thêm món ăn mới
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['CategoryID'], $data['ProductName'], $data['Price'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request data']);
            exit;
        }

        try {
            $stmt = $pdo->prepare('INSERT INTO Products (CategoryID, ProductName, Price, ImageURL, IsAvailable) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([
                $data['CategoryID'],
                $data['ProductName'],
                $data['Price'],
                $data['ImageURL'] ?? null,
                $data['IsAvailable'] ?? 1
            ]);
            echo json_encode(['success' => true, 'ProductID' => $pdo->lastInsertId()]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to add product']);
        }
        break;

    case 'PUT':
        // Cập nhật món ăn
        parse_str(file_get_contents('php://input'), $data);
        if (!isset($data['ProductID'])) {
            http_response_code(400);
            echo json_encode(['error' => 'ProductID is required']);
            exit;
        }

        try {
            $stmt = $pdo->prepare('UPDATE Products SET CategoryID = ?, ProductName = ?, Price = ?, ImageURL = ?, IsAvailable = ? WHERE ProductID = ?');
            $stmt->execute([
                $data['CategoryID'] ?? null,
                $data['ProductName'] ?? null,
                $data['Price'] ?? null,
                $data['ImageURL'] ?? null,
                $data['IsAvailable'] ?? 1,
                $data['ProductID']
            ]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update product']);
        }
        break;

    case 'DELETE':
        // Xóa món ăn
        parse_str(file_get_contents('php://input'), $data);
        if (!isset($data['ProductID'])) {
            http_response_code(400);
            echo json_encode(['error' => 'ProductID is required']);
            exit;
        }

        try {
            $stmt = $pdo->prepare('DELETE FROM products WHERE ProductID = ?');
            $stmt->execute([$data['ProductID']]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete product']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}
?>
