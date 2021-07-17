<?php
session_start();

@include_once('dbConnect.php');

if(!isset($_SESSION['Email']) && !isset($_SESSION['EmailVerificationToken'])){
  $sql = "SELECT * FROM users WHERE Id = :Id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(['Id'=>$_SESSION['newUserId']]);
  $user = $stmt -> fetch();
  $Email = $user -> Email;
  $Token = $user -> EmailVerificationToken;
}else {
  $Email = $_SESSION['Email'];
  $Token = $_SESSION['EmailVerificationToken'];
}


//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
  //Server settings
  $mail->SMTPDebug = SMTP::DEBUG_SERVER;
  $mail->SMTPOptions = array(
    'ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => true
    )
  );                     
  $mail->isSMTP();      
  // $mail->Host       = 'smtp.gmail.com';     
  $mail->Host       = '108.177.126.109';                 //Set the SMTP server to send through
  $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
  $mail->Username   = 'doej43253@gmail.com';                     //SMTP username
  $mail->Password   = '';                               //SMTP password
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
  $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

  //Recipients
  $mail->setFrom('doej43253@gmail.com');
  $mail->addAddress($Email);     //Add a recipient


  //Content
  $mail->isHTML(true);                                  //Set email format to HTML
  $mail->Subject = 'Here is the subject';
  
  $mail->send();
  echo 'Message has been sent';

  header("Location: index.php");
  exit();

} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
