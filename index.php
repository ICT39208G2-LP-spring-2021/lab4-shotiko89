<?php 
session_start();
// session_unset();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        h2 {
            text-align: center;
            margin-bottom: 50px;
        }

        h3 {
            text-align: center;
        }

        form {
            width: 300px;
            margin: 0 auto;
        }

        input {
            display: block;
            margin: 0 auto;
            width: 80%;
            font-size: 14px;
        }

        label {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 30px;
            position: relative;
        }

        label span {
            position: absolute;
            top: 0;
            left: 0px;
            color: red;
        }

        label .error {
            margin: 0 auto;
            margin-top: 5px;
            width: 80%;
            font-size: 12px;
            color: red;
        }
        #resend {
            color: orange;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h2>რეგისტრაცია</h2>
    <?php if (!isset($_SESSION["submissionSuccess"])) { ?>
        <form action="add-user.php" class="form" method="post">
            <label>
                <input type="text" name="FirstName" placeholder="სახელი" value = "<?php echo (isset($FirstName)) ? $FirstName : ''; ?>">
                <span class="error">*</span>
                <?php if (isset($_SESSION['FirstNameError'])) { ?>
                    <div class="error"><?php echo $_SESSION['FirstNameError'] ?></div>
                <?php } ?>
            </label>
            <label>
                <input type="text" name="LastName" placeholder="გვარი" value = "<?php echo (isset($LastName)) ? $LastName : ''; ?>">
                <span>*</span>
                <?php if (isset($_SESSION['LastNameError'])) { ?>
                    <div class="error"><?php echo $_SESSION['LastNameError'] ?></div>
                <?php } ?>
            </label>
            <label>
                <input type="text" name="PersonalNumber" placeholder="პირადი ნომერი" value = "<?php echo (isset($PersonalNumber)) ? $PersonalNumber : ''; ?>">
                <span>*</span>
                <?php if (isset($_SESSION['PersonalNumberError'])) { ?>
                    <div class="error"><?php echo $_SESSION['PersonalNumberError'] ?></div>
                <?php } ?>
            </label>
            <label>
                <input type="text" name="Email" placeholder="მეილი" value = "<?php echo (isset($Email)) ? $Email : ''; ?>">
                <span>*</span>
                <?php if (isset($_SESSION['EmailError'])) { ?>
                    <div class="error"><?php echo $_SESSION['EmailError'] ?></div>
                <?php } ?>
            </label>
            <label>
                <input type="password" name="Password" placeholder="პაროლი">
                <span>*</span>
                <?php if (isset($_SESSION['PasswordError'])) { ?>
                    <div class="error"><?php echo $_SESSION['PasswordError'] ?></div>
                <?php } ?>
            </label>
            <input type="submit" value="submit">
        </form>
    <?php } else { ?>
        <h3>იუზერი დარეგისტრირებულია</h3>
        <p>ნახე აქტივაციის ლინკი მეილზე</p>

        <?php if(isset($_SESSION['attemptsCount']) && $_SESSION['attemptsCount'] > 0) { ?>
            <p>თუ არ მოგსვლია <span id='resend'>გააგზავნე ლინკი თავიდან</span></p>
        <?php  } else { ?>
            <p>თავიდან გაგზავნის ლიმიტი ამოიწერა</p>
        <?php  } ?>
    <?php } ?>

    <script>
        $("#resend").click(function(){
            $.ajax({
                url : 'resend-email.php',
                type : 'post',
                success : function(data){
                    alert('გაიგზავნა');
                    window.location.reload();
                }
            });
        });
    </script>
</body>
</html>
