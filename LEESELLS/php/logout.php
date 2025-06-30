<?php
//start session
session_start();

//clear all session varibles
session_unset();

//destroy session
session_destroy();
//redirect to login page
header("Location: login.html");

?>