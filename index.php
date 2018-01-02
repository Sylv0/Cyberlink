<?php
declare(strict_types=1);
require(__DIR__.'/views/header.php');
?>

<main class="container-fluid">
    <?php if(isset($_SESSION['userid'])): ?>
        <form name="postForm" onsubmit="return false;" class="col-lg-10 col-md-12">
          <fieldset class="form-group">
            <label for="formGroupExampleInput">Title</label>
            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Your title" name="postTitle" required>
          </fieldset>
          <fieldset class="form-group">
            <label for="formGroupExampleInput2">Text</label>
            <textarea rows="4" type="text" class="form-control" id="formGroupExampleInput2" placeholder="Your text" name="postText" required></textarea>
          </fieldset>
          <input type="hidden" name="postAuthor" value="<?php echo $_SESSION['userid']; ?>">
          <input type="submit" name="postSubmit" value="Post" class="btn btn-primary">
        </form>
        <script src="assets/scripts/posts.js" charset="utf-8"></script>
    <?php
else:
    echo "Not logged in, please do.";
    endif; ?>
    <div class="row posts">

    </div>
</main>
<?php require(__DIR__.'/views/footer.php'); ?>
