<style>
    .profile-img{
        max-height: 150px;
        max-width: 250px;
    }
</style>

<?php
    require 'views/header.php';
    if(!isset($_SESSION['userid'])) redirect('.');

    if(isset($_GET['targetUser'])) {
        $target = $_GET['targetUser'];
    } else {
        $target = $_SESSION['userid'];
    }

    $statement = $pdo->prepare("SELECT id, nickname, email, bio, avatar_url, regDate from users WHERE id=:id");
    $statement->bindParam(":id", $target, PDO::PARAM_INT);

    if (!$statement->execute()) {
        echo $pdo->errorInfo();
        die;
        //redirect('./login.php');
    }

    $data = $statement->fetch(PDO::FETCH_ASSOC);
    if($data === false){
        echo "No user found with that idea.";
        die;
    }
?>
<div class="container">
    <div class="reviews">
    <div class="row blockquote">
        <div class="col-md-3 text-center">
        <img class="profile-img" src="<?php echo $data['avatar_url']; ?>">

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

<?php
    if($_SESSION['userid'] == $data['id']):
?>
<div class="container">
    <form name="regUserForm" enctype="multipart/form-data" action="app/users/update.php" method="post">
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
            <input name="avatar" type="file" class="form-control" id="updateAvatar" aria-describedby="updateAv" placeholder="Select file" accept="image/*" value="<?php echo $data['avatar_url']; ?>">
        </div>
        <div class="form-group">
            <label for="regPassw">Password</label>
            <input name="passw" type="password" class="form-control" id="regPassw" placeholder="Password">
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
        $getPosts = $pdo->prepare("SELECT * FROM posts WHERE authorID=:user ORDER BY postID DESC");
        $getPosts->bindParam(':user', $target);
        if(!$getPosts->execute()) echo "Something went wrong while loading the accounts posts, please refresh page.";
        $posts = $getPosts->fetchAll(PDO::FETCH_ASSOC);
        foreach($posts as $post):
    ?>
    <div class="card mt-4">
        <a href="${post['imageURL']}" class="card-header" onclick="return false;">
            <?php echo $post['title']; ?>
        </a>
        <div class="card-body row">
            <blockquote class="blockquote mb-0 col-10">
                <p><?php echo $post['postText']; ?></p>
                <footer class="blockquote-footer"> <cite title="Source Title"><?php echo $post['postTime']; ?></cite> (<?php echo $post['updateTime']; ?>)</footer>
            </blockquote>
        </div>
    </div>
    <?php
        if($_SESSION['userid'] == $post['authorID']):
    ?>
        <a href="#" class="btn btn-sm btn-primary">Update</a>
        <a href="app/posts/delete.php?post=<?php echo $post['postID']; ?>" class="btn btn-sm btn-danger" onclick="if(!confirm('Are you sure?')) return false;">Remove</a>
    <?php
        endif;
        endforeach;
    ?>
</div>

<?php require 'views/footer.php'; ?>
