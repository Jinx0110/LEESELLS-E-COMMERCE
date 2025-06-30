<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($email) || empty($password)) {
        die("Error: All fields are required");
    }
}
    $host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "shopusers_db";

    $conn = mysqli_connect($host, $db_user, $db_password, $db_name);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT username, password_hash, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user["password_hash"])) {
            // Set session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["email"] = $email;
            $_SESSION["username"] = $user["username"];
            $_SESSION["role"] = $user["role"];

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: adminDashboard.html?login=success");
            } else {
                header("Location: index.html?login=success");
            }
            exit();
        } else {
            echo "Error: Incorrect password";
        }
    } else {
        echo "Error: Email not found";
    }

    $stmt->close();
    mysqli_close($conn);
?>
