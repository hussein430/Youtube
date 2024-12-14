<?php
class User
{
    private $con, $sqlData;

    public function __construct($con, $username)
    {
        $this->con = $con;

        $query = $this->con->prepare("SELECT * FROM users WHERE username = :un");
        $query->bindParam(":un", $username);
        $query->execute();

        $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);

        // Handle the case where the query fails to fetch data
        if ($this->sqlData === false) {
            // Optionally, you can throw an exception or set a default value
            $this->sqlData = null;
        }
    }

    public static function isLoggedIn() {
        return isset($_SESSION["userLoggedIn"]);
    }

    public function getUsername()
    {
        return $this->sqlData ? $this->sqlData["username"] : null;
    }

    public function getName()
    {
        return $this->sqlData ? $this->sqlData["firstName"] . " " . $this->sqlData["lastName"] : null;
    }

    public function getFirstName()
    {
        return $this->sqlData ? $this->sqlData["firstName"] : null;
    }

    public function getLastName()
    {
        return $this->sqlData ? $this->sqlData["lastName"] : null;
    }

    public function getEmail()
    {
        return $this->sqlData ? $this->sqlData["email"] : null;
    }

    public function getProfilePic()
    {
        return $this->sqlData ? $this->sqlData["profilePic"] : null;
    }

    public function getSignUpDate()
    {
        return $this->sqlData ? $this->sqlData["signUpDate"] : null;
    }
}
