<?php
session_start();
require_once "dbConnect.php";

if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
    header("location: home.php");
    exit;
}
$email = $password = "";
$emailError = $passwordError = '';
$loginError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['Email'])) {
        $emailError = "მეილი სავალდებულოა";
    } else {
        $email = $_POST['Email'];
    }
    if (empty($_POST['Password'])) {
        $passwordError = "პაროლი სავალდებულოა";
    } else {
        $password = $_POST['Password'];
    }

    if (empty($emailError) && empty($passwordError)) {
        $sql = "SELECT Id, FirstName, LastName, Email, HashedPassword, StatusID, EmailVerificationToken FROM users WHERE Email = :Email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['Email' => $email]);
        if ($stmt->rowCount() == 1) {
            $result = $stmt->fetch();
            $Id = $result -> Email;
            $Email = $result -> Email;
            $FirstName = $result -> FirstName;
            $LastName = $result -> LastName;
            $hashedPassword = $result -> HashedPassword;
            $StatusID = $result -> StatusID;
            $EmailVerificationToken = $result -> EmailVerificationToken;

            if (password_verify($password, $hashedPassword)) {

                session_start();

                $_SESSION["loggedin"] = true;
                $_SESSION["email"] = $Email;
                $_SESSION["firstName"] = $FirstName;
                $_SESSION["lastName"] = $LastName;
                $_SESSION["statusId"] = $StatusID;
                $_SESSION["emailVerificationToken"] = $EmailVerificationToken;

                header("location: home.php");
            } else {
                $passwordError = "Incorrect password.";
            }
        } else {
            $emailError = "Invalid email";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label>
            <input type="text" name="Email" placeholder="მეილი" value="<?php echo (isset($Email)) ? $Email : ''; ?>">
        </label>
        <label>
            <input type="text" name="Password" placeholder="პაროლი">
        </label>
        <?php if (isset($loginError)) { ?>
            <div style="color: red"><?php echo $loginError ?></div>
        <?php } ?>
        <?php if (isset($emailError)) { ?>
            <div style="color: red"><?php echo $emailError ?></div>
        <?php } ?>
        <?php if (isset($passwordError)) { ?>
            <div style="color: red"><?php echo $passwordError ?></div>
        <?php } ?>
        <input type="submit" value="submit">
    </form>
</body>

</html>