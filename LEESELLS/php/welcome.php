<?php

//start session

session_start();



//check if user is logged in

if(!isset($_SESSION["loggedin"])||$_SESSION["loggedin"]!==true){

    header("Location: login.html");

    exit;

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Welcome</title>

    <link rel="stylesheet" href="styles.css">

</head>

<body>

    <div class="container">

        <h2>Welcome, <?php echo $_SESSION["username"]; ?>!</h2>

        <p>You have successfully logged in.</p>

        <a href="logout.php"> <button>Logout</button> </a>

    </div>

</body>

</html>