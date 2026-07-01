<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=utf-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$target_dir = "../public/uploads/products/";

// Create directory if not exists
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

if (!isset($_FILES["image"])) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "No file uploaded"]);
    exit;
}

$file = $_FILES["image"];
$imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
$check = getimagesize($file["tmp_name"]);
if($check === false) {
    echo json_encode(["success" => false, "error" => "File is not an image."]);
    exit;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    echo json_encode(["success" => false, "error" => "Only JPG, JPEG, PNG & GIF files are allowed."]);
    exit;
}

// Generate unique filename
$newfilename = uniqid() . '.' . $imageFileType;
$target_file = $target_dir . $newfilename;

if (move_uploaded_file($file["tmp_name"], $target_file)) {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";

    // Lấy IP thực của request (tránh trường hợp HTTP_HOST = 'localhost' trong Docker)
    $host = $_SERVER['HTTP_HOST'];
    // Nếu host là localhost hoặc tên container, dùng SERVER_ADDR
    if ($host === 'localhost' || strpos($host, '127.') === 0 || !filter_var(explode(':', $host)[0], FILTER_VALIDATE_IP)) {
        $serverIp = $_SERVER['SERVER_ADDR'] ?? $host;
        // SERVER_ADDR trong Docker có thể là IP container, thử HTTP_X_FORWARDED_HOST trước
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
        } elseif (isset($_SERVER['HTTP_X_REAL_IP'])) {
            $host = $_SERVER['HTTP_X_REAL_IP'];
        } else {
            // Lấy IP từ header Origin của request (FE gọi từ IP nào thì dùng IP đó)
            if (isset($_SERVER['HTTP_ORIGIN'])) {
                $originParts = parse_url($_SERVER['HTTP_ORIGIN']);
                $originHost  = $originParts['host'] ?? '';
                $originPort  = isset($originParts['port']) ? ':' . $originParts['port'] : '';
                if ($originHost && $originHost !== 'localhost') {
                    // Dùng IP của FE nhưng với port 80 (BE port)
                    $host = $originHost;
                }
            }
        }
    }

    $public_url = $protocol . "://" . $host . "/public/uploads/products/" . $newfilename;
    
    echo json_encode(["success" => true, "url" => $public_url]);
} else {
    echo json_encode(["success" => false, "error" => "Sorry, there was an error uploading your file."]);
}
?>
