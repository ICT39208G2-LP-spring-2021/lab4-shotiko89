<?php
session_start();
session_unset();

$FirstName = $LastName =  $PersonalNumber = $Email = $HashedPassword = $StatusId = '';
$hasError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST['FirstName'])) {
        $_SESSION["FirstNameError"] = "სახელი სავალდებულოა";
    } else {
        $FirstName = $_POST['FirstName'];
    }

    if (empty($_POST['LastName'])) {
        $_SESSION["LastNameError"] = "გვარი სავალდებულოა";
    } else {
        $LastName = $_POST['LastName'];
    }

    if (empty($_POST['LastName'])) {
        $_SESSION["PersonalNumberError"] = "პირადი ნომერი სავალდებულოა";
    } else {
        $PersonalNumber = $_POST['PersonalNumber'];
    }

    if (empty($_POST['Email'])) {
        $_SESSION["EmailError"] = "მეილი სავალდებულოა";
    } else {
        $Email = $_POST['Email'];
    }

    if (empty($_POST['Password'])) {
        $_SESSION["PasswordError"] = "პაროლი სავალდებულოა";
    } else {
        $HashedPassword = password_hash($_POST['Password'], PASSWORD_DEFAULT);
    }
}

@include_once('dbConnect.php');

if (!(isset($_SESSION["FirstNameError"], $_SESSION["LastNameError"], $_SESSION["PersonalNumberError"], $_SESSION["EmailError"], $_SESSION["PasswordError"]))) {
    $sql = "SELECT * FROM users WHERE Email = :Email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['Email' => $Email]);
    $existingEmail = $stmt->fetch(PDO::FETCH_BOUND);

    if ($existingEmail) {
        $_SESSION["EmailError"] = 'მეილი უვკე დარეგისტრირებულია';
        $hasError = true;
    }

    $sql = "SELECT * FROM users WHERE PersonalNumber = :PersonalNumber LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['PersonalNumber' => $PersonalNumber]);
    $existingPersonalNumber = $stmt->fetch(PDO::FETCH_BOUND);

    if ($existingPersonalNumber) {
        $_SESSION["PersonalNumberError"] = 'პირადი ნომერი უკვე დარეგისტრირებულია';
        $hasError = true;
    }

    if (!$hasError) {
        $EmailVerificationToken = md5(rand(0,1000));
        $sql = "INSERT INTO users (FirstName, LastName, PersonalNumber, Email, HashedPassword, EmailVerificationToken) VALUES (:FirstName, :LastName, :PersonalNumber, :Email, :HashedPassword, :EmailVerificationToken)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute(['FirstName' => $FirstName, 'LastName' => $LastName, 'PersonalNumber' => $PersonalNumber, 'Email' => $Email, 'HashedPassword' => $HashedPassword, 'EmailVerificationToken' => $EmailVerificationToken]);
        if($result){
            $sql = "SELECT * FROM users WHERE EmailVerificationToken = :EmailVerificationToken";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['EmailVerificationToken'=>$EmailVerificationToken]);
            $newUser = $stmt -> fetch();
            $_SESSION['newUserId'] = $newUser->Id;
            $_SESSION["submissionSuccess"] = true;
            $_SESSION["attemptsCount"] = 5;

            header("Location: send-email.php");
            exit();
        }
    }else {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

// include 'index.php';
