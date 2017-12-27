<?php require 'views/header.php'; ?>

<?php 
    if(!isset($_SESSION['userid'])) redirect('.');

    $statement = $pdo->prepare("SELECT nickname, email, bio, avatar_url from users WHERE id=:id");
    $id = $_SESSION['userid'];
    $statement->bindParam(":id", $id, PDO::PARAM_INT);

    if (!$statement->execute()) {
        redirect('.');
    }

    $data = $statement->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
    <form name="regUserForm" onsubmit="return false;">
        <div class="form-group">
            <label for="regEmail">Email address</label>
            <input name="email" type="email" class="form-control" id="regEmail" aria-describedby="regEmailHelp" placeholder="Enter email" value="<?php echo $data['email'] ?>" required>
            <small id="regEmailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="bio">Biography</label>
            <textarea class="form-control" name="bio" id="bio" rows="3" placeholder="About you"><?php echo $data['bio']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="regPassw">Password</label>
            <input name="passw" type="password" class="form-control" id="regPassw" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-regUser">Register</button>
    </form>
</div>

<?php require 'views/footer.php'; ?>