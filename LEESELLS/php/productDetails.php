<?php

header('Content-Type: application/json');


$host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "shopusers_db";

// Establish connection
$conn = new mysqli($host, $db_user, $db_password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'] ?? '';
if (!$id) {
    http_response_code(400);
    echo json_encode(['error' => 'No ID provided']);
    exit;
}

$stmt = $conn->prepare("SELECT id, name, seller, price, image, description FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($product = $result->fetch_assoc()) {
    echo json_encode($product);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Product not found']);
}
$stmt->close();
$conn->close();
?>
