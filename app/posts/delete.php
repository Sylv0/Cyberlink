<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// In this file we delete new posts in the database.
if(!isset($_GET['post'])){
    redirect('../../profile.php');
}

$removePost = $pdo->prepare("DELETE FROM posts WHERE postID = :id");
$removePost->bindParam(':id', $_GET['post']);
if(!$removePost->execute()){
    echo "Something went wrong<br><a href='../../profile.php'>Go back</a>";
}

redirect('../../profile.php');