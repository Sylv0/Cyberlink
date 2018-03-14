<?php

/*
 * This file is part of Yrgo.
 *
 * (c) Yrgo, högre yrkesutbildning.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

    declare(strict_types=1);

    if (isset($_POST['session_id'])) {
        session_id($_POST['session_id']);
    }

    require '../autoload.php';

    if (isset($_SESSION['userid'])) {
        echo json_encode(['error'=>true, 'errorInfo'=>'A user is already logged in.']);
        die;
    }

    if (!isset($_POST['email']) || !isset($_POST['passw'])) {
        echo json_encode(['error'=>true, 'errorInfo'=>'No data']);
        die;
    }

    //echo json_encode(['email'=>$_POST['email'], 'passw'=>$_POST['passw']]);

    $statement = $pdo->prepare('SELECT id, email, passw FROM users WHERE email = :email');
    $statement->bindParam(':email', $_POST['email']);

    if (!$statement->execute()) {
        echo json_encode(['error' => true, 'errorInfo'=>$pdo->errorInfo()]);
    }

    $data = $statement->fetch(PDO::FETCH_ASSOC);

    // echo password_verify($_POST['passw'], $data['passw']);
    // die;

    if (isset($data['passw'])) {
        if (password_verify($_POST['passw'], $data['passw'])) {
            $_SESSION['userid'] = $data['id'];
            echo json_encode('Logged in I guess '.$_SESSION['userid']);
            die;
        }
        echo json_encode(['error'=>true, 'errorInfo'=>'Password was not set in database']);
        die;
    } else {
        echo json_encode(['error' => true, 'errorInfo'=>'User not found']);
    }
