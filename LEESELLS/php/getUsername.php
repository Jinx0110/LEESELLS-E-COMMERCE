<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    echo json_encode(["username" => $_SESSION["username"]]);
} else {
    echo json_encode(["username" => null]);
}
?>
