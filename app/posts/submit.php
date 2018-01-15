<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// In this file we store/insert new posts in the database.
if (!isset($_POST['title']) || !isset($_POST['text']) || !isset($_POST['author'])) {
    echo json_encode(['error' => true, 'errorInfo' => 'Something went wrong']);
    die;
}

$statement = $pdo->prepare('INSERT INTO posts(authorID, title, postText, image_url, postTime, updateTime) VALUES (:authid, :title, :inText, :imageURL, datetime(), datetime())');

$title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
$text = filter_var($_POST['text'], FILTER_SANITIZE_STRING);
$imageURL = filter_var($_POST['link'], FILTER_SANITIZE_URL);

$statement->bindParam(':authid', $_POST['author']);
$statement->bindParam(':title', $title);
$statement->bindParam(':inText', $text);
$statement->bindParam(':imageURL', $imageURL);

if(!$statement->execute()){
    echo json_encode(['error' => true, 'errorInfo' => $pdo->errorInfo()]);
    die;
}
echo json_encode(['submited' => true]);
