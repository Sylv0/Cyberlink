<?php 
    declare(strict_types=1);
    require '../autoload.php';

    $checkVote = $pdo->prepare('SELECT * FROM postVotes WHERE userID=:user AND postID=:post');
    $checkVote->bindParam(':user', $_POST['userID']);
    $checkVote->bindParam(':post', $_POST['postID']);
    if($checkVote->execute() && $checkVote->fetch()){
        echo json_encode(['voted'=>true]);
    }else{
        $saveVote = $pdo->prepare('INSERT INTO postVotes(postID, userID, vote) VALUES (:post, :user, :vote)');
        $saveVote->bindParam(':post', $_POST['postID']);
        $saveVote->bindParam(':user', $_POST['userID']);
        $saveVote->bindParam(':vote', $_POST['vote']);
        if(!$saveVote->execute()){
            echo json_encode(['error'=>true, 'errorInfo'=>$pdo->errorInfo()]);
            die;
        }
        echo json_encode(['voteSaved'=>true, 'voteUp'=>($_POST['vote'] == 1)]);
    }
?>