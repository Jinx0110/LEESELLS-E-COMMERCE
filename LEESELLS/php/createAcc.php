<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST["username"]) ? trim($_POST["username"]) : '';
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : '';
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Error: Invalid email format");
    }

    // Database connection variables
    $host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "shopusers_db"; 

    // Establish connection
    $conn = new mysqli($host, $db_user, $db_password, $db_name);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $check = mysqli_query($conn,$sql);
    if(mysqli_num_rows($check) > 0){
        die("Error: username already exists");
    }

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $check = mysqli_query($conn, $sql);
    if (mysqli_num_rows($check) > 0){
        die("Error: Email already registered");
    }

    // Hashing the password
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(username, email, password_hash) VALUES ('$username', '$email', '$hash')";
    if (mysqli_query($conn, $sql)){
        // header("Location:login.html");
        header("Location: login.html?registered=1");
        exit;
    } else{
        echo "Error: " .mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
