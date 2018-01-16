<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

if(!isset($_POST['title']) || !isset($_POST['text']) || !isset($_POST['postID'])){
    echo json_encode(['success'=>false]);
    redirect('../../profile.php');
}

$title = trim(filter_var($_POST['title'], FILTER_SANITIZE_STRING));
$text = trim(filter_var($_POST['text'], FILTER_SANITIZE_STRING));
$id = trim(filter_var($_POST['postID'], FILTER_SANITIZE_STRING));

$updateData = $pdo->prepare('UPDATE posts SET title=:title, postText=:postText, updateTime=datetime() WHERE postID=:id');
$updateData->bindParam('title', $title);
$updateData->bindParam('postText', $text);
$updateData->bindParam('id', $id);
$updateData->execute();

$getData = $pdo->prepare('SELECT title, postText, updateTime FROM posts WHERE postID=:id');
$getData->bindParam(':id', $id);
$getData->execute();
echo json_encode(['success'=>true, 'newData'=>$getData->fetch(PDO::FETCH_ASSOC)]);
die;