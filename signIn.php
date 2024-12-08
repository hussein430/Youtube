<?php
require_once "includes/config.php";
require_once "includes/classes/Account.php";
require_once "includes/classes/Constants.php";
require_once "includes/classes/FormSanitizer.php";

$account = new Account($con);

if (isset($_POST["submitButton"])) {

    $username = FormSanitizer::sanitizeFormUsername($_POST["userName"]);
    $password =  FormSanitizer::sanitizeFormPassword($_POST["password"]);

    $wasSuccessful = $account->login($username, $password);

    if ($wasSuccessful) {
        $_SESSION["userLoggedIn"]= $username;
        header("Location: index.php");
    }
}


function getInputValue($name){
    if(isset($_POST[$name])){
        echo $_POST[$name];
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>YouTube</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- My CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">

    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>

<body>

    <div class="signInContainer">
        <div class="column mt-5 shadow p-3 mb-5 bg-body-tertiary rounded">

            <div class="header">
                <img src="assets/images/icons/youtube.svg" alt="logo">
                <h3>Sign In</h3>
                <span>to continue to YouTube</span>
            </div>

            <div class="loginForm">
                <form action="signIn.php" method="POST">
                <?php echo $account->getError(Constants::$loginFailed) ?>
                    <input type="text" class="form-control" name="userName" placeholder="Username" autocomplete="off" value="<?php getInputValue('userName'); ?>" required>
                    <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off" required>
                    <input class="btn btn-primary" type="submit" name="submitButton" value="SUBMIT">
                </form>
            </div>

            <a class="signInMessage" href="signUp.php">Need an account? Sign up here!</a>
        </div>

    </div>

</body>

</html>