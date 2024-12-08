<?php
require_once "includes/config.php";
require_once "includes/classes/FormSanitizer.php";
require_once "includes/classes/Account.php";
require_once "includes/classes/Constants.php";

$account = new Account($con);


if (isset($_POST["submitButton"])) {

    $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
    $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);

    $userName = FormSanitizer::sanitizeFormUsername($_POST["userName"]);

    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
    $email2 = FormSanitizer::sanitizeFormEmail($_POST["email2"]);

    $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
    $password2 = FormSanitizer::sanitizeFormPassword($_POST["password2"]);

    $wasSuccessful = $account->register($firstName, $lastName, $userName, $email, $email2, $password, $password2);

    if ($wasSuccessful) {
        $_SESSION["userLoggedIn"]= $userName;
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
                <h3>Sign Up</h3>
                <span>to continue to YouTube</span>
            </div>

            <div class="loginForm">
                <form action="signUp.php" method="post">
                    <?php echo $account->getError(Constants::$firstNameCharacters) ?>
                    <input type="text" class="form-control" name="firstName" placeholder="First Name" autocomplete="off" value="<?php getInputValue('firstName'); ?>" required>

                    <?php echo $account->getError(Constants::$lastNameCharacters) ?>
                    <input type="text" class="form-control" name="lastName" placeholder="Last Name" autocomplete="off" value="<?php getInputValue('lastName'); ?>" required>

                    <?php echo $account->getError(Constants::$userNameCharacters) ?>
                    <?php echo $account->getError(Constants::$userNameTaken) ?>
                    <input type="text" class="form-control" name="userName" placeholder="Username" autocomplete="off" value="<?php getInputValue('userName'); ?>" required>

                    <?php echo $account->getError(Constants::$emailsDoNotMatch) ?>
                    <?php echo $account->getError(Constants::$emailInvalid) ?>
                    <?php echo $account->getError(Constants::$emailTaken) ?>
                    <input type="email" class="form-control" name="email" placeholder="Email" autocomplete="off"  value="<?php getInputValue('email'); ?>"required>
                    <input type="email" class="form-control" name="email2" placeholder="Confirm Email" autocomplete="off" value="<?php getInputValue('email2'); ?>" required>

                    <?php echo $account->getError(Constants::$passwordDoNotMatch) ?>
                    <?php echo $account->getError(Constants::$passwordLength) ?>
                    <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off" required>
                    <input type="password" class="form-control" name="password2" placeholder="Confirm Password" autocomplete="off" required>

                    <input class="btn btn-primary" type="submit" name="submitButton" value="SUBMIT">
                </form>
            </div>

            <a class="signInMessage" href="signIn.php">Already have an account? Sign in here!</a>
        </div>

    </div>

</body>

</html>