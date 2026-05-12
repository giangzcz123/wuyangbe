<?php
require_once '../config/db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Lấy báo cáo doanh thu theo khoảng thời gian
        $startDate = $_GET['startDate'] ?? null;
        $endDate = $_GET['endDate'] ?? null;

        if (!$startDate || !$endDate) {
            http_response_code(400);
            echo json_encode(['error' => 'Start date and end date are required']);
            exit;
        }

        try {
            $stmt = $pdo->prepare('
                SELECT DATE(o.CreatedAt) as Date, COALESCE(SUM(i.Quantity * p.Price), 0) as Revenue
                FROM Orders o
                LEFT JOIN OrderItems i ON o.OrderID = i.OrderID
                LEFT JOIN Products p ON i.ProductID = p.ProductID
                WHERE DATE(o.CreatedAt) BETWEEN ? AND ? AND o.Status = ?
                GROUP BY DATE(o.CreatedAt)
            ');
            $stmt->execute([$startDate, $endDate, 'Paid']);
            $revenue = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($revenue);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to fetch revenue report']);
        }
        break;

    case 'POST':
        // Thống kê điểm đánh giá sao trung bình
        try {
            $stmt = $pdo->prepare('SELECT AVG(Rating) as AverageRating FROM Feedbacks');
            $stmt->execute();
            $averageRating = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($averageRating);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to fetch rating report']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}
?>
// Update: Format lai JSON response cho Chart.js
