<?php 
    $getData = $pdo->prepare("SELECT * FROM users WHERE id=:id");
    $getData->bindParam(':id', $_SESSION['userid']);
    if(!$getData->execute()){
        echo json_encode(['error'=>true, 'errorInfo'=>'An error occured while getting the user.']);
    }

    $update = $pdo->prepare("UDATE users SET (email, bio, passw, avatar_url)");
?>