<!DOCTYPE html>
<html lang="en">
<?php
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>home</title>
</head>

<body>
    <h2>Home Page</h2>
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) { ?>
        <div><?php echo $_SESSION['firstName'] . ' ' . $_SESSION['lastName'] ?></div>
        <?php if (isset($_SESSION['statusId']) && $_SESSION['statusId'] == 0) { ?>
            <p>ექაუნთი არ არის გააქტიურებული <span id='resend' style='color: orange;'>გააგზავნე აქტივაციის ლინკი მეილზე</span></p>
        <?php } ?>
    <?php } else {
        header("location: login.php");
        exit;
    } ?>
    <script>
        $("#resend").click(function() {
            $.ajax({
                url: 'resend-email.php',
                type: 'post',
                success: function(data) {
                    alert('გაიგზავნა');
                    window.location.reload();
                }
            });
        });
    </script>
</body>

</html>