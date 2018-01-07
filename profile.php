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
            <label for="updateAvatar">Email address</label>
            <input name="avatar" type="file" class="form-control" id="updateAvatar" aria-describedby="updateAv" placeholder="Select file" type="image/*" required>
        </div>
        <div class="form-group">
            <label for="regPassw">Password</label>
            <input name="passw" type="password" class="form-control" id="regPassw" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-regUser">Update</button>
    </form>
    <hr>
</div>
<div class="container">
<h3>Your posts</h3>
<?php 
    $getPosts = $pdo->prepare("SELECT * FROM posts WHERE authorID=:user ORDER BY postID DESC");
    $getPosts->bindParam(':user', $_SESSION['userid']);
    if(!$getPosts->execute()) echo "Something went wrong while loading your posts, please refresh page.";
        $posts = $getPosts->fetchAll(PDO::FETCH_ASSOC);
    foreach($posts as $post){
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
    <a href="#" class="btn btn-sm btn-primary">Update</a>
    <a href="app/posts/delete.php?post=<?php echo $post['postID']; ?>" class="btn btn-sm btn-danger" onclick="if(!confirm('Are you sure?')) return false;">Remove</a>
<?php
    }
?>
</div>

<?php require 'views/footer.php'; ?>