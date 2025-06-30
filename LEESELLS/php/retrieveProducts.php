<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection 
$host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "shopusers_db";

$conn = new mysqli($host, $db_user, $db_password, $db_name);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

$sql = "
    SELECT 
        p.product_id,
        p.name AS product_name, 
        p.price, 
        p.category,
        p.image_url,
        u.user_id AS seller_id,
        u.username AS seller_name
    FROM products p
    JOIN users u ON p.seller_id = u.user_id
    WHERE u.role = 'seller'
";

$result = $conn->query($sql);

$products = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        // Replace backslashes with forward slashes for web compatibility
        // $imagePath = str_replace('\\', '/', $row['image_url']);

        // Convert to web-accessible URL
        $imagePath = '/uploads/' . basename($row['image_url']);

        $products[] = [
        "product_id" => (int)$row['product_id'],
        "name" => $row['product_name'],
        "price" => $row['price'],
        "category" => $row['category'],
        "image" => $imagePath,
        "seller" => $row['seller_name'],
        "seller_id" => (int)$row['seller_id']
        ];
    }
    echo json_encode($products);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Query failed: " . $conn->error]);
}

$conn->close();
?>
