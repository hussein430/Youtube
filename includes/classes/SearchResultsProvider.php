<?php
class SearchResultsProvider
{
    private $con, $userLoggedInObj;

    public function __construct(PDO $con, User $userLoggedInObj)
    {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function getVideos($term, $orderBy)
    {
        $validOrders = ["views", "uploadDate"];
        $orderBy = in_array($orderBy, $validOrders) ? $orderBy : "views";
    
        $query = $this->con->prepare("SELECT * FROM videos WHERE title LIKE :term OR uploadedBy LIKE :term ORDER BY $orderBy DESC");
        $termWithWildcards = "%$term%";
        $query->bindParam(":term", $termWithWildcards);
        $query->execute();
    
        $videos = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $video = new Video($this->con, $row, $this->userLoggedInObj);
            array_push($videos, $video);
        }
    
        return $videos;
    }
    
}
