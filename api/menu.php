<?php
// require_once '../config/db.php';

// header('Content-Type: application/json; charset=utf-8');

// try {
//     $stmt = $pdo->prepare('SELECT c.CategoryID, c.CategoryName, p.ProductName, p.Price, p.ImageURL FROM categories c JOIN products p ON c.CategoryID = p.CategoryID WHERE p.IsAvailable = 1 ORDER BY c.DisplayOrder, p.ProductName');
//     $stmt->execute();

//     $menu = [];
//     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//         $menu[$row['CategoryID']] = [
//             'CategoryName' => $row['CategoryName'],
//             'Products' => $menu[$row['CategoryID']]['Products'] ?? []
//         ];
//         $menu[$row['CategoryID']]['Products'][] = [
//             'ProductName' => $row['ProductName'],
//             'Price' => $row['Price'],
//             'ImageURL' => $row['ImageURL']
//         ];
//     }

//     echo json_encode(array_values($menu), JSON_UNESCAPED_UNICODE);
// } catch (PDOException $e) {
//     http_response_code(500);
//     echo json_encode(['error' => 'Failed to fetch menu'], JSON_UNESCAPED_UNICODE);
// }

require_once '../config/db.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $stmt = $pdo->prepare(
        'SELECT 
            c.CategoryID,
            c.CategoryName,
            p.ProductID,
            p.ProductName,
            p.Price,
            p.ImageURL
         FROM categories c
         JOIN products p ON c.CategoryID = p.CategoryID
         WHERE p.IsAvailable = 1
         ORDER BY c.DisplayOrder, p.ProductName'
    );
    $stmt->execute();

    $menu = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (!isset($menu[$row['CategoryID']])) {
            $menu[$row['CategoryID']] = [
                'CategoryID'   => $row['CategoryID'],
                'CategoryName' => $row['CategoryName'],
                'Products'     => [],
            ];
        }

        $menu[$row['CategoryID']]['Products'][] = [
            'ProductID'   => $row['ProductID'],
            'ProductName' => $row['ProductName'],
            'Price'       => $row['Price'],
            'ImageURL'    => $row['ImageURL'],
        ];
    }

    echo json_encode(array_values($menu), JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch menu'], JSON_UNESCAPED_UNICODE);
}
