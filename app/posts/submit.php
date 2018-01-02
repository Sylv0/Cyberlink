<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// In this file we store/insert new posts in the database.
if (!isset($_POST['title']) || !isset($_POST['text']) || !isset($_POST['author'])) {
    echo json_encode(['error' => true, 'errorInfo' => 'Something went wrong']);
    die;
}

$statement = $pdo->prepare('INSERT INTO posts(authorID, title, postText, postTime, updateTime) VALUES (:authid, :title, :inText, :date, :date)');
// die(var_dump($pdo->errorInfo()));
$statement->bindParam(':authid', $_POST['author']);
$statement->bindParam(':title', $_POST['title']);
$statement->bindParam(':inText', $_POST['text']);
$date = Date('Y-m-d H:i:s');
$statement->bindParam(':date', $date);

if(!$statement->execute()){
    echo json_encode(['error' => true, 'errorInfo' => $pdo->errorInfo()]);
    die;
}
echo json_encode(['submited' => true]);
