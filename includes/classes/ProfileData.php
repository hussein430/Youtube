<?php
    class ProfileData{
        private $con, $profileUserObj;

        public function __construct($con, $profileUserObj){
            $this->con = $con;
            $this->profileUserObj = new User($con, $profileUserObj);
        }

        public function getProfileUserObj(){
            return $this->profileUserObj;
        }

        public function getProfileUsername(){
            return $this->profileUserObj->getUsername();
        }

        public function userExists(){
            $username = $this->getProfileUsername();
            $query = $this->con->prepare("SELECT * FROM users WHERE username=:username");
            $query->bindParam(":username", $username);
            $query->execute();

            return $query->rowCount() != 0;
        } 

        public function getCoverPhoto(){
            return "assets/images/coverPhotos/default-cover-photo.jpg";
        }

        public function getProfileUserFullName(){
            return $this->profileUserObj->getName();
        }

        public function getProfilePic(){
            return $this->profileUserObj->getProfilePic();
        }

        public function getSubscriberCount(){
            return $this->profileUserObj->getSubscriberCount();
        }

        public function getUsersVideos(){
            $username = $this->getProfileUsername();
            $query = $this->con->prepare("SELECT * FROM videos WHERE uploadedBy=:uploadedBy ORDER BY uploadDate DESC");
            $query->bindParam(":uploadedBy", $username);
            $query->execute();

            $videos = array();
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $videos[] = new Video($this->con, $row, $this->profileUserObj->getUsername());
            }

            return $videos;
        }

        public function getAllUserDetails(){
            return array(
                "Name" => $this->getProfileUserFullName(),
                "Username" => $this->getProfileUsername(),
                "Subscribers" => $this->getSubscriberCount(),
                "Total Views" => $this->getTotalViews(),
                "Signup Date" => $this->getSignUpDate()
            );
        }

        private function getTotalViews(){
            $username = $this->getProfileUsername();
            $query = $this->con->prepare("SELECT sum(views) as total FROM videos WHERE uploadedBy=:uploadedBy");
            $query->bindParam(":uploadedBy", $username);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC)["total"];
        }

        private function getSignUpDate(){
            return $this->profileUserObj->getSignUpDate();
        }
    }
?>