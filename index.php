<?php
declare(strict_types=1);
require(__DIR__.'/views/header.php');
?>

<main class="container-fluid">
    <?php if(isset($_SESSION['userid'])): ?>
        <form name="postForm">
          <fieldset class="form-group">
            <label for="formGroupExampleInput">Title</label>
            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Your title" name="postTitle">
          </fieldset>
          <fieldset class="form-group">
            <label for="formGroupExampleInput2">Text</label>
            <textarea rows="4" type="text" class="form-control" id="formGroupExampleInput2" placeholder="Your text" name="postText"></textarea>
          </fieldset>
          <input type="hidden" name="postAuthor" value="<?php echo $_SESSION['userid']; ?>">
          <input type="submit" name="postSubmit" value="Post" class="btn btn-primary">
        </form>
    <?php endif; ?>
    <div class="row posts">

    </div>
    <script src="assets/scripts/posts.js" charset="utf-8"></script>
</main>
<?php require(__DIR__.'/views/footer.php'); ?>
