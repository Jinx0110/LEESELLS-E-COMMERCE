<?php
$host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "shopusers_db";

// Establish connection
$conn = new mysqli($host, $db_user, $db_password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

$users = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
echo json_encode($users);
$conn->close();
?>
