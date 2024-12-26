<?php
    require_once("includes/header.php");
    require_once("includes/classes/SearchResultsProvider.php");

    if (!isset($_GET["term"]) || $_GET["term"] == "") {
        echo "You must enter a search term";
        exit();
    }

    // htmlspecialchars() is used to prevent XSS attacks
    $term = htmlspecialchars($_GET["term"], ENT_QUOTES, 'UTF-8');

    if (!isset($_GET["orderBy"]) || $_GET["orderBy"] == "views") {
        $orderBy = "views";
    }else{
        $orderBy = "uploadDate";
    }

    $searchResultsProvider = new SearchResultsProvider($con, $userLoggedInObj);
    $videos = $searchResultsProvider->getVideos($term, $orderBy);
    $videoGrid = new VideoGrid($con, $userLoggedInObj);
?>

<div class="largeVideoGridContainer">
    <?php
        if (sizeof($videos) > 0) {
            echo $videoGrid->createLarge($videos, "Videos that contain \"$term\"", true);
        }else{
            echo "No results found";
        }
    ?>
</div>



<?php
    require_once("includes/footer.php");
?>