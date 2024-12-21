<?php
require_once("../includes/config.php");
require_once("../includes/classes/User.php");
require_once("../includes/classes/Comment.php");

if (
    isset($_POST['commentText']) &&
    isset($_POST['postedBy']) &&
    isset($_POST['videoId'])
) {

    // Ensure the user is logged in
    if (!isset($_SESSION["userLoggedIn"])) {
        echo "You must be logged in to post a comment.";
        exit();
    }

    $userLoggedInObj = new User($con, $_SESSION["userLoggedIn"]);

    $postedBy = htmlspecialchars($_POST['postedBy']);
    $videoId = intval($_POST['videoId']);
    $responseTo = isset($_POST['responseTo']) ? intval($_POST['responseTo']) : 0;
    $commentText = trim($_POST['commentText']);

    if (empty($commentText)) {
        echo "Comment text cannot be empty.";
        exit();
    }

    $query = $con->prepare("INSERT INTO comments(postedBy, videoId, responseTo, body) 
                                        VALUES(:postedBy, :videoId, :responseTo, :body)");
    $query->bindParam(":postedBy", $postedBy);
    $query->bindParam(":videoId", $videoId);
    $query->bindParam(":responseTo", $responseTo);
    $query->bindParam(":body", $commentText);
    $query->execute();

    $newComment = new Comment($con, $con->lastInsertId(), $userLoggedInObj, $videoId);
    echo $newComment->create();
} else {
    echo "one or more parameters are not passed into subscribe.php the file";
}
