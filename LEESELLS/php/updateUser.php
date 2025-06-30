<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['user_id'], $data['username'], $data['email'], $data['role'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
    exit;
}

$host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "shopusers_db";

$conn = new mysqli($host, $db_user, $db_password, $db_name);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'DB connection failed: ' . $conn->connect_error]);
    exit;
}

$user_id = (int)$data['user_id'];
$username = $conn->real_escape_string($data['username']);
$email = $conn->real_escape_string($data['email']);
$role = $conn->real_escape_string($data['role']);

$stmt = $conn->prepare("UPDATE users SET username=?, email=?, role=? WHERE user_id=?");
$stmt->bind_param("sssi", $username, $email, $role, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
