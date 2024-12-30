<?php
require_once "ProfileData.php";

class ProfileGenerator
{
    private $con, $userLoggedInObj, $profileUserData;

    public function __construct($con, $userLoggedIn, $profileUsername)
    {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedIn;
        $this->profileUserData = new ProfileData($con, $profileUsername);
    }

    public function create()
    {
        $profileUsername = $this->profileUserData->getProfileUsername();
        if (!$this->profileUserData->userExists()) {
            return "User does not exist";
        }

        $coverPhotoSection = $this->createCoverPhotoSection();
        $headerSection = $this->createHeaderSection();
        $tabsSection = $this->createTabsSection();
        $contentSection = $this->createContentSection();

        return "<div class='profileContainer'>
                    $coverPhotoSection
                    $headerSection
                    $tabsSection
                    $contentSection
                </div>";
    }

    public function createCoverPhotoSection()
    {
        $coverPhotoSrc = $this->profileUserData->getCoverPhoto();
        $name = $this->profileUserData->getProfileUserFullName();
        return "<div class='coverPhotoContainer'>
                    <img src='$coverPhotoSrc' class='coverPhoto'>
                    <span class='name'>$name</span>
                </div>";
    }

    public function createHeaderSection()
    {
        $profileImage = $this->profileUserData->getProfilePic();
        $name = $this->profileUserData->getProfileUserFullName();
        $subCount = $this->profileUserData->getSubscriberCount();

        $button = $this->createHeaderButton();

        return "<div class='profileHeader'>
                    <div class='userInfoContainer'>
                        <img class='profileImage' src='$profileImage'>
                        <div class='userInfo'>
                            <span class='title'>$name</span>
                            <span class='subscriberCount'>$subCount subscribers</span>
                        </div> 
                    </div>

                    <div class='buttonContainer'>
                        <div class='buttonItem'>
                            $button
                        </div>
                    </div>

                </div>";
    }

    public function createTabsSection()
    {

        return "<ul class='nav nav-tabs mt-4' role='tablist'>
                    <li class='nav-item'>
                        <a class='nav-link active' id='videos-tab' data-toggle='tab' href='#videos' role='tab' aria-controls='videos' aria-selected='true'>VIDEOS</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' id='about-tab' data-toggle='tab' href='#about' role='tab' aria-controls='about' aria-selected='false'>ABOUT</a>
                    </li>
                </ul>";
    }

    public function createContentSection()
    {
        $videos = $this->profileUserData->getUsersVideos();

        if (sizeof($videos) > 0) {
            $videoGrid = new VideoGrid($this->con, $this->userLoggedInObj);
            $videoGridHtml = $videoGrid->create($videos, null, false);
        } else {
            $videoGridHtml = "<span>This user has no videos</span>";
        }

        $aboutSection = $this->createAboutSection();

        return "<div class='tab-content channelContent'>
                    <div class='tab-pane fade show active' id='videos' role='tabpanel' aria-labelledby='videos-tab'>
                            $videoGridHtml
                    </div>
                    <div class='tab-pane fade' id='about' role='tabpanel' aria-labelledby='about-tab'>
                            $aboutSection
                    </div>
                </div>";
    }

    private function createHeaderButton()
    {
        if ($this->userLoggedInObj->getUsername() == $this->profileUserData->getProfileUsername()) {
            return "";
        } else {
            // return "<button class='subscribeButton'>Subscribe</button>";
            return ButtonProvider::createSubscriberButton(
                $this->con,
                $this->profileUserData->getProfileUserObj(),
                $this->userLoggedInObj
            );
        }
    }

    private function createAboutSection()
    {
        $html = "<div class='section'>
                    <div class='title'>
                        <span>Details</span>
                    </div>
                    <div class='values'>";
                    $details = $this->profileUserData->getAllUserDetails();
                    foreach ($details as $key => $value) {
                        $html .= "<span>$key: $value</span>";
                    }
        $html .= "</div></div>";

        return $html;
    }
}
