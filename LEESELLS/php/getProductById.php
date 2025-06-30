<?php
header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing product ID"]);
    exit();
}

$id = intval($_GET['id']);

$host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "shop_users";

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
        p.image_url, 
        p.description,
        u.username AS seller_name,
        p.is_accessory
    FROM products p
    JOIN users u ON p.seller_id = u.user_id
    WHERE p.product_id = $id
";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $imagePath = str_replace('\\', '/', $row['image_url']);
    $product = [
        "id" => $row['product_id'],
        "name" => $row['product_name'],
        "price" => $row['price'],
        "preview" => $imagePath,
        "description" => $row['description'],
        "brand" => $row['seller_name'],
        "isAccessory" => (bool)$row['is_accessory'],
        // For product photos array, add if you have multiple images stored
        "photos" => [$imagePath] 
    ];
    echo json_encode($product);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Product not found"]);
}

$conn->close();
?>
