<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

$getData = $pdo->prepare('SELECT * FROM users WHERE id=:id');
$getData->bindParam(':id', $_SESSION['userid']);
$getData->execute();
$data = $getData->fetch(PDO::FETCH_ASSOC);

$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$bio = filter_var($_POST['bio'], FILTER_SANITIZE_STRING);
$url = filter_var($_POST['avatar'], FILTER_SANITIZE_URL);
$id = $_SESSION['userid'];

$updateData = $pdo->prepare('UPDATE users SET email=:email, bio=:bio, avatar_url=:avatar WHERE id=:id');
$updateData->bindParam(':email', $email);
$updateData->bindParam(':bio', $bio);
$updateData->bindParam(':avatar', $url);
$updateData->bindParam(':id', $id);
$updateData->execute();
$pdo->errorInfo();
redirect('../../profile.php');