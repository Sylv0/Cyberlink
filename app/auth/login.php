<?php
    declare(strict_types=1);
    if(!isset($_POST['email']) || !isset($_POST['passw'])){
        echo json_encode(['error'=>true, 'errorInfo'=>'No data']);
        die;
    }

    require '../autoload.php';

    //echo json_encode(['email'=>$_POST['email'], 'passw'=>$_POST['passw']]);

    $statement = $pdo->prepare("SELECT id, email, passw FROM users WHERE email = :email");
    $statement->bindParam(':email', $_POST['email']);

    if(!$statement->execute()){
        echo json_encode(['error' => true, 'errorInfo'=>$pdo->errorInfo()]);
    }

    // echo json_encode($statement->fetch(PDO::FETCH_ASSOC)['passw']);
    // die;

    $pass = $statement->fetch(PDO::FETCH_ASSOC)['passw'];

    if(isset($statement->fetch(PDO::FETCH_ASSOC)['passw'])){
        if (password_verify($_POST['passw'], $pass)) {
            # code...
        }
        echo json_encode($statement->fetch(PDO::FETCH_ASSOC));
        die;
    }

    echo json_encode(['error' => true, 'errorInfo'=>'User not found']);