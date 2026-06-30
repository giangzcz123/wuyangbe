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
        // Lấy danh sách định mức
        try {
            $stmt = $pdo->prepare('SELECT r.ProductID, p.ProductName, r.IngredientID, i.IngredientName, r.AmountRequired
                                   FROM recipes r
                                   JOIN products p ON r.ProductID = p.ProductID
                                   JOIN Ingredients i ON r.IngredientID = i.IngredientID');
            $stmt->execute();
            $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($recipes);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to fetch recipes']);
        }
        break;

    case 'POST':
        // Thêm định mức mới
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['ProductID'], $data['IngredientID'], $data['AmountRequired'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request data']);
            exit;
        }

        try {
            $stmt = $pdo->prepare('INSERT INTO Recipes (ProductID, IngredientID, AmountRequired) VALUES (?, ?, ?)');
            $stmt->execute([
                $data['ProductID'],
                $data['IngredientID'],
                $data['AmountRequired']
            ]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to add recipe']);
        }
        break;

    case 'DELETE':
        // Xóa định mức
        parse_str(file_get_contents('php://input'), $data);
        if (!isset($data['ProductID'], $data['IngredientID'])) {
            http_response_code(400);
            echo json_encode(['error' => 'ProductID and IngredientID are required']);
            exit;
        }

        try {
            $stmt = $pdo->prepare('DELETE FROM recipes WHERE ProductID = ? AND IngredientID = ?');
            $stmt->execute([$data['ProductID'], $data['IngredientID']]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete recipe']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}
?>
