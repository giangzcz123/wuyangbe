<?php
require_once '../config/db.php';
header('Content-Type: application/json; charset=utf-8');

try {
    $stmt = $pdo->prepare('SELECT CategoryID, CategoryName FROM categories ORDER BY DisplayOrder');
    $stmt->execute();

    $categories = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $categories[] = [
            'CategoryID' => $row['CategoryID'],
            'CategoryName' => $row['CategoryName']
        ];
    }

    echo json_encode($categories, JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch categories'], JSON_UNESCAPED_UNICODE);
}
?>


