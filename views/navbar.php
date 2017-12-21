<nav class="navbar navbar-expand-md navbar-light bg-light">
    <a class="navbar-brand" href="#"><img src="assets/images/logo.svg" width="30" height="30" class="d-inline-block align-top" alt=""><span class="visible-sm">Cyberlink</span></a>
    <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
        aria-expanded="false" aria-label="Toggle navigation"></button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link" href=".">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo isset($_SESSION['userid']) ? "makepost.php" : "login.php"; ?>">Make Post</a>
            </li>
        </ul>
        <?php if(!isset($_SESSION['userid'])): ?>
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0 justify-content-end">
            <li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
            </li>
        </ul>
        <?php endif; ?>
    </div>
</nav>