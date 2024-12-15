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

    public function isSubscribedTo($userTo){
        $username = $this->getUsername();

        $query = $this->con->prepare("SELECT * FROM subscribers WHERE userTo=:userTo AND userFrom=:userFrom");
        $query->bindParam(":userTo", $userTo);
        $query->bindParam(":userFrom", $username); 
        $query->execute();

        return $query->rowCount() > 0;
    }

    public function getSubscriberCount(){
        $username = $this->getUsername();

        $query = $this->con->prepare("SELECT * FROM subscribers WHERE userTo=:userTo");
        $query->bindParam(":userTo", $username);
        $query->execute();

        return $query->rowCount();
    }
}
