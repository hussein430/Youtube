<?php
class SettingsFormProvider
{
    public function createUserDetailsForm($firstName, $lastName, $email)
    {
        $firstNameInput = $this->createFirstNameInput($firstName);
        $lastNameInput = $this->createLastNameInput($lastName);
        $emailInput = $this->createEmailInput($email);
        $saveButton = $this->createSaveUserDetailsButton();

        return "<form method='POST' action='settings.php'>
                    <h2 class='formTitle'>User details</h2>
                    $firstNameInput
                    $lastNameInput
                    $emailInput
                    $saveButton
                </form>";
    } 

    public function createPasswordForm()
    {
        $oldPasswordInput = $this->createPasswordInput("oldPassword", "Old password");
        $newPassword1Input = $this->createPasswordInput("newPassword", "New password");
        $newPassword2Input = $this->createPasswordInput("newPassword2", "Confirm new password");
        $saveButton = $this->createSavePasswordButton();

        return "<form method='POST' action='settings.php'>
                    <h2 class='formTitle'>Update password</h2>
                    $oldPasswordInput
                    $newPassword1Input
                    $newPassword2Input
                    $saveButton
                </form>";
    }

    private function createFirstNameInput($value)
    {
        if ($value == null) $value = "";
        return "
                <div class='form-group'>
                    <input type='text' class='form-control' name='firstName' placeholder='First name' value='$value' required>        
                </div>";
    }

    private function createLastNameInput($value)
    {
        if ($value == null) $value = "";
        return "
                <div class='form-group'>
                    <input type='text' class='form-control' name='lastName' placeholder='Last name' value='$value' required> 
                </div>";
    }

    private function createEmailInput($value)
    {
        if ($value == null) $value = "";
        return "
                <div class='form-group'>
                    <input type='email' class='form-control' name='email' placeholder='Email' value='$value' required>
                </div>";
    }

    private function createSaveUserDetailsButton()
    {
        return "<button type='submit' class='btn btn-primary' name='saveDetailsButton'>Save</button>";
    }

    private function createPasswordInput($name, $placeholder)
    {
        return "
                <div class='form-group'>
                    <input type='password' class='form-control' name='$name' placeholder='$placeholder' required>
                </div>";
    }

    private function createSavePasswordButton()
    {
        return "<button type='submit' class='btn btn-primary' name='savePasswordButton'>Save</button>";
    }
}
