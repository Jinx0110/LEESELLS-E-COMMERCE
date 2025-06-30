<?php
$host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "shopusers_db";
$conn = new mysqli($host, $db_user, $db_password, $db_name);

if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$sql = "SELECT user_id, username FROM users WHERE role='seller'";
$result = $conn->query($sql);

$sellers = [];
while($row = $result->fetch_assoc()) {
    $sellers[] = $row;
}
header('Content-Type: application/json');
echo json_encode($sellers);
$conn->close();
?>
