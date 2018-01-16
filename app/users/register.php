<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';

$user = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$passw = password_hash(filter_var($_POST['passw'], FILTER_SANITIZE_STRING), PASSWORD_DEFAULT);

$statement = $pdo->prepare("INSERT INTO users(nickname, email, passw, regDate) VALUES(:username, :email, :passw, datetime())");
$statement->bindParam(':username', $user, PDO::PARAM_STR);
$statement->bindParam(':email', $email, PDO::PARAM_STR);
$statement->bindParam(':passw', $passw, PDO::PARAM_STR);

if(!$statement->execute()){
    echo json_encode(["error"=>true, "errorInfo"=>$pdo->errorInfo()]);
    return;
    exit;
    die;
}

echo json_encode(["error"=>false, 'data'=>$_POST]);
