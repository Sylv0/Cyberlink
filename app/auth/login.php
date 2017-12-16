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

    $data = $statement->fetch(PDO::FETCH_ASSOC);

    if(isset($data['passw'])){
        if (password_verify($_POST['passw'], $data['passw'])) {
            echo "Logged in I guess";
            $_SESSION['userid'] = $data['id'];
            die;
        }
        echo json_encode(['error'=>true, 'errorInfo'=>"Password was not set in database"]);
        die;
    }

    echo json_encode(['error' => true, 'errorInfo'=>'User not found']);