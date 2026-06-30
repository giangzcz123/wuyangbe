<?php
require_once '../config/db.php';
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit; }

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['Rating']) || $data['Rating'] < 1 || $data['Rating'] > 5) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request data']);
    exit;
}

try {
    $orderId = isset($data['OrderID']) && $data['OrderID'] ? $data['OrderID'] : null;

    // Nếu Frontend không truyền OrderID thì tự tra OrderID mới nhất theo TableID
    if (!$orderId && isset($data['TableID'])) {
        $stmt = $pdo->prepare(
            'SELECT OrderID FROM orders WHERE TableID = ? ORDER BY CreatedAt DESC LIMIT 1'
        );
        $stmt->execute([$data['TableID']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $orderId = $row ? $row['OrderID'] : null;
    }

    if (!$orderId) {
        http_response_code(400);
        echo json_encode(['error' => 'Cannot determine OrderID']);
        exit;
    }

    $stmt = $pdo->prepare('INSERT INTO Feedbacks (OrderID, Rating, Comment) VALUES (?, ?, ?)');
    $stmt->execute([$orderId, $data['Rating'], $data['Comment'] ?? null]);

    echo json_encode(['success' => true, 'FeedbackID' => $pdo->lastInsertId()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to submit feedback', 'message' => $e->getMessage()]);
}
?>
// Giang update
