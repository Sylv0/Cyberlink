<?php
    declare(strict_types=1);
    require '../autoload.php';
    if(!isset($_POST)){
        echo json_encode(['error'=>true]);
        die;
    }
    if(isset($_POST['getAll']) && $_POST['getAll']){
        $getPosts = $pdo->prepare('SELECT p.postID, p.title, p.postText, p.postTime, p.updateTime, p.image_url, u.nickname AS author, u.id AS userID FROM posts AS p, users AS u WHERE p.authorID=u.id');
        if(!$getPosts->execute()){
            echo json_encode(["error"=>true, "errorInfo"=>"Couldn't get posts."]);
            die;
        }
        echo json_encode($getPosts->fetchAll(PDO::FETCH_ASSOC));
        die;
    }else if(isset($_POST['getLatest']) && $_POST['getLatest']){
        $getPosts = $pdo->prepare('SELECT p.postID, p.title, p.postText, p.postTime, p.updateTime, p.image_url, u.nickname AS author, u.id AS userID FROM posts AS p, users AS u WHERE p.authorID=u.id ORDER BY p.postID DESC LIMIT 1');
        if(!$getPosts->execute()){
            echo json_encode(["error"=>true, "errorInfo"=>"Couldn't get posts."]);
            die;
        }
        echo json_encode($getPosts->fetch(PDO::FETCH_ASSOC));
        die;
    }else if(isset($_POST['getVotes']) && $_POST['getVotes']){
        $getVotes = $pdo->prepare('SELECT * FROM postVotes');
        $getVotes->execute();
        echo json_encode($getVotes->fetchAll(PDO::FETCH_ASSOC));
    }
