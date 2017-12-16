<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
//if(sizeof($_POST) === 0) redirect('../../');

// echo json_encode($_POST);
// die;

$user = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$passw = password_hash(filter_var($_POST['passw'], FILTER_SANITIZE_STRING), PASSWORD_DEFAULT);

$statement = $pdo->prepare("INSERT INTO users(nickname, email, passw) VALUES(:username, :email, :passw)");
$statement->bindParam(':username', $user, PDO::PARAM_STR);
$statement->bindParam(':email', $email, PDO::PARAM_STR);
$statement->bindParam(':passw', $passw, PDO::PARAM_STR);
// $statement->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
// $statement->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
// $statement->bindParam(':passw', $_POST['passw'], PDO::PARAM_STR);

if(!$statement->execute()){
    echo json_encode(["error"=>true, "errorInfo"=>$pdo->errorInfo()]);
    return;
    exit;
    die;
}

echo json_encode(["error"=>false, 'data'=>$_POST]);
//redirect('../../login.php');