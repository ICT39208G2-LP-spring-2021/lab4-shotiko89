<?php
@include_once('dbConnect.php');
$Token = $_GET['token'];
$sql = "UPDATE users SET StatusId = 1 WHERE EmailVerificationToken = :EmailVerificationToken";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute(['EmailVerificationToken' => $Token]);
if($result){
    echo 'ექაუნთი გააქტიურდა';
}
?>