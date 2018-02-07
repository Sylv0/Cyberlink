<?php
    require 'views/header.php';
    if(!isset($_SESSION['userid'])) redirect('./login.php');

    if(isset($_GET['targetUser'])) {
        $target = $_GET['targetUser'];
    } else {
        $target = $_SESSION['userid'];
    }

    // $statement = $pdo->prepare("SELECT id, nickname, email, bio, avatar_url, regDate from users WHERE id=:id");
    // $statement->bindParam(":id", $target, PDO::PARAM_INT);
    // $data = $statement->fetch(PDO::FETCH_ASSOC);
    $data = SelectFromBD($pdo, "SELECT id, nickname, email, bio, avatar_url, regDate from users WHERE id=?", [$target], false);
    if($data === false){
        echo "No user found with that idea.";
        die;
    }
?>
<style>
    .profile-img{
        max-height: 150px;
        max-width: 250px;
    }
</style>

<div class="container">
    <div class="reviews">
    <div class="row blockquote">
        <div class="col-md-3 text-center">
        <img class="profile-img mt-3" src="<?php echo $data['avatar_url']; ?>">

        </div>
        <div class="col-md-9">
        <h4><?php echo $data['nickname'] ?></h4>
        <p class="review-text"><?php if(strlen($data['bio']) == 0){ echo "No bio."; } else { echo $data['bio']; } ?></p>
        <small class="review-date"><?php echo $data['email']; ?></small>
        <small class="review-date"><br>Member since: <?php echo $data['regDate']; ?></small>
        </div>
    </div>
    </div>
</div>

<div class="container">
<?php
    if($_SESSION['userid'] == $data['id']):
        if(isset($_GET['passchange']) && $_GET['passchange'] == 'true'):
?>
    <div class="alert alert-success alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> Password changed.
    </div>
<?php elseif (isset($_GET['passchange']) && $_GET['passchange'] == 'false'): ?>
    <div class="alert alert-warning alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Warning!</strong> Indicates a warning that might need attention.
    </div>
<?php endif; ?>
    <form name="updateUserForm" enctype="multipart/form-data" action="app/users/update.php" method="post">
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
            <label for="updateAvatar">Avatar</label>
            <input name="avatar" type="file" class="form-control" id="updateAvatar" aria-describedby="updateAv" placeholder="Select file" accept="image/*">
            URL: <input type="checkbox" name="urlcheck">
        </div>
        <div class="form-group">
            <label for="regPasswOld">Old Password (NOT READY YET)</label>
            <input name="passwOld" type="password" class="form-control" id="regPasswOld" placeholder="Password">
        </div>
        <div class="form-group">
            <label for="regPasswNew">New Password</label>
            <input name="passwNew" type="password" class="form-control" id="regPasswNew" placeholder="Password">
        </div>
        <div class="form-group">
            <label for="regPasswRepeat">Repeat New Password</label>
            <input name="passwRepeat" type="password" class="form-control" id="regPasswRepeat" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary btn-regUser">Update</button>
    </form>
    <hr>
</div>
<?php
    endif;
?>
<div class="container">
    <h3>Accounts posts</h3>
    <?php
        // $getPosts = $pdo->prepare("SELECT * FROM posts WHERE authorID=:user ORDER BY postID DESC");
        // $getPosts->bindParam(':user', $target);
        // if(!$getPosts->execute()) echo "Something went wrong while loading the accounts posts, please refresh page.";
        // $posts = $getPosts->fetchAll(PDO::FETCH_ASSOC);
        $posts = SelectFromBD($pdo, "SELECT * FROM posts WHERE authorID=? ORDER BY postID DESC", [$target], true);
        foreach($posts as $post):
    ?>
    <div class="card mt-4 post" data-postid="<?php echo $post['postID']; ?>">
        <a href="<?php echo $post['image_url']; ?>" target="_blank" class="card-header postTitle" onclick="if(this.getAttribute('href') == '') return false;"><?php echo $post['title']; ?></a>
        <input type="text" class="editTitle d-none">
        <div class="card-body row">
            <blockquote class="blockquote mb-0 col-10">
                <p class="postText"><?php echo $post['postText']; ?></p>
                <textarea name="" id="" cols="30" rows="10" class="editText d-none"></textarea>
                <footer class="blockquote-footer"> <cite title="Source Title"><?php echo $post['postTime']; ?></cite> (<span class="updateTime"><?php echo $post['updateTime']; ?></span>)</footer>
            </blockquote>
        </div>
    </div>
    <?php
        if($_SESSION['userid'] == $post['authorID']):
    ?>
        Edit: <input type="checkbox" class="editPostCheck" data-postid="<?php echo $post['postID']; ?>">
        <a href="app/posts/delete.php?post=<?php echo $post['postID']; ?>" class="btn btn-sm btn-danger" onclick="if(!confirm('Are you sure?')) return false;">Remove</a>
    <?php
        endif;
        endforeach;
    ?>
</div>
<script src="assets/scripts/profile.js"></script>
<?php require 'views/footer.php'; ?>
