<?php

session_start();
$user_id = $_SESSION['user_id'];
session_unset();
header('Location:login');

?>