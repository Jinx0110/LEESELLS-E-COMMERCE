<?php
header('Content-Type: application/json');

// Database connection variables
$host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "shopusers_db";

// Connect to database
$conn = new mysqli($host, $db_user, $db_password, $db_name);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// Query total products count
$productResult = $conn->query("SELECT COUNT(*) AS total_products FROM products");
$productCount = 0;
if ($productResult) {
    $row = $productResult->fetch_assoc();
    $productCount = (int)$row['total_products'];
}

// Query total customers count (assuming customers are users with role 'customer' or similar)
$userResult = $conn->query("SELECT COUNT(*) AS total_customers FROM users WHERE role = 'customer'");
$customerCount = 0;
if ($userResult) {
    $row = $userResult->fetch_assoc();
    $customerCount = (int)$row['total_customers'];
}

$conn->close();

echo json_encode([
    'success' => true,
    'total_products' => $productCount,
    'total_customers' => $customerCount
]);
exit;
?>
