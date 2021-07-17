<?php 
session_start();
$_SESSION["attemptsCount"] -= 1;
if($_SESSION["attemptsCount"] > 0){
    header("Location: send-email.php");
    exit();
}else {
    header("Location: index.php");
    exit();
}
?>