<?php
    declare(strict_types=1);
    require '../autoload.php';
    if(!isset($_POST)){
        echo json_encode(['error'=>true]);
        die;
    }
    if(isset($_POST['getAll']) && $_POST['getAll']){
        // $getPosts = $pdo->prepare('SELECT p.postID, p.title, p.postText, p.postTime, p.updateTime, p.image_url, u.nickname AS author, u.id AS userID FROM posts AS p, users AS u WHERE p.authorID=u.id');
        // if(!$getPosts->execute()){
        //     echo json_encode(["error"=>true, "errorInfo"=>"Couldn't get posts."]);
        //     die;
        // }
        // echo json_encode($getPosts->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode(SelectFromBD($pdo, "SELECT p.postID, p.title, p.postText, p.postTime, p.updateTime, p.image_url, u.nickname AS author, u.id AS userID FROM posts AS p, users AS u WHERE p.authorID=u.id", [], true));
    }else if(isset($_POST['getLatest']) && $_POST['getLatest']){
        // $getPosts = $pdo->prepare('SELECT p.postID, p.title, p.postText, p.postTime, p.updateTime, p.image_url, u.nickname AS author, u.id AS userID FROM posts AS p, users AS u WHERE p.authorID=u.id ORDER BY p.postID DESC LIMIT 1');
        // if(!$getPosts->execute()){
        //     echo json_encode(["error"=>true, "errorInfo"=>"Couldn't get posts."]);
        //     die;
        // }
        // echo json_encode($getPosts->fetch(PDO::FETCH_ASSOC));
        echo json_encode(SelectFromBD($pdo, "SELECT p.postID, p.title, p.postText, p.postTime, p.updateTime, p.image_url, u.nickname AS author, u.id AS userID FROM posts AS p, users AS u WHERE p.authorID=u.id ORDER BY p.postID DESC LIMIT 1", [], false));
    }else if(isset($_POST['getVotes']) && $_POST['getVotes']){
        // if(isset($_POST['id'])){
        //     $getVotes = $pdo->prepare('SELECT * FROM postVotes WHERE :id');
        //     $getVotes->bindParam(':id', $_POST['id']);
        // }else{
        //     $getVotes = $pdo->prepare('SELECT * FROM postVotes');
        // }
        // $getVotes->execute();
        // echo json_encode($getVotes->fetchAll(PDO::FETCH_ASSOC));
        if(isset($_POST['id'])){
            echo json_encode(SelectFromBD($pdo, "SELECT * FROM postVotes WHERE postID=?", [$_POST['id']], true));
        }else{
            echo json_encode(SelectFromBD($pdo, "SELECT * FROM postVotes", [], true));
        }
    }