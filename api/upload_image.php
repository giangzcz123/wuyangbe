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
    // Return the URL relative to the API or absolute if needed
    // In this case, let's return a URL that the React app can use
    // Assuming the public root is http://localhost:8088/hadilaoPHP/public/
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $public_url = $protocol . "://" . $host . "/public/uploads/products/" . $newfilename;
    
    echo json_encode(["success" => true, "url" => $public_url]);
} else {
    echo json_encode(["success" => false, "error" => "Sorry, there was an error uploading your file."]);
}
?>
