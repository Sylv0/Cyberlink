<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

$id = $_SESSION['userid'];
$getData = $pdo->prepare('SELECT * FROM users WHERE id=:id');
$getData->bindParam(':id', $id);
$getData->execute();
$data = $getData->fetch(PDO::FETCH_ASSOC);
if(strlen($_POST['email']) > 0 && $_POST['email'] != $data['email']){
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $updateEmail = $pdo->prepare('UPDATE users SET email=:email WHERE id=:id');
    $updateEmail->bindParam(':email', $email);
    $updateEmail->bindParam(':id', $id);
    $updateEmail->execute();
}
if(strlen($_POST['bio']) > 0 && $_POST['bio'] != $data['bio']){
    $bio = filter_var($_POST['bio'], FILTER_SANITIZE_STRING);
    $updateBio = $pdo->prepare('UPDATE users SET bio=:bio WHERE id=:id');
    $updateBio->bindParam(':bio', $bio);
    $updateBio->bindParam(':id', $id);
    $updateBio->execute();
}
if(isset($_FILES['avatar'])){
    $target_dir = "users/".$data['nickname']."/";
    $target_file = $target_dir . "profileImage.png";

    if(!mkdir("../../".$target_dir, 0777, true)) echo "Folder already exists";

    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], "../../".$target_file)) {
        $updateAvatar = $pdo->prepare('UPDATE users SET avatar_url=:avatar WHERE id=:id');
        $updateAvatar->bindParam(':avatar', $target_file);
        $updateAvatar->bindParam(':id', $id);
        $updateAvatar->execute();
        echo "The file ". basename( $_FILES["avatar"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
redirect('../../profile.php');