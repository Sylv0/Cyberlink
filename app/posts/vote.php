<?php 
    declare(strict_types=1);
    require '../autoload.php';

    $checkVote = $pdo->prepare('SELECT * FROM postVotes WHERE userID=:user AND postID=:post');
    $checkVote->bindParam(':user', $_POST['userID']);
    $checkVote->bindParam(':post', $_POST['postID']);
    if($checkVote->execute()){
        echo json_encode(['voted'=>true]);
    }
?>