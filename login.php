<?php
declare(strict_types=1);
require __DIR__.'/views/header.php';
if (isset($_SESSION['userid'])) {
    redirect('.');
}
?>
<main class="container">
    <div class="row">
        <div class="col-12 bg-warning loginError">
            <span>Some generic error about a user</span>
        </div>
    </div>
    <div class="row mt-auto">
        <div class="col-md-12 col-lg-10">
            <h4>Log in</h4>
            <form name="loginUserForm">
                <div class="form-group">
                    <label for="loginEmail">Email address</label>
                    <input name="email" type="email" class="form-control" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="loginPassw">Password</label>
                    <input name="passw" type="password" class="form-control" placeholder="Password" required>
                </div>
                <input name="sessid" type="hidden" value="<?php echo session_id(); ?>">
                <button type="submit" class="btn btn-primary btn-loginUser">Login</button>
            </form>
        </div>
    </div>
    <hr>
    <div class="row mt-auto">
        <div class="col-md-12 col-lg-10">
            <h4>Or register</h4>
            <form name="regUserForm" onsubmit="return false;">
                <div class="form-group">
                    <label for="regUsername">Username</label>
                    <input name="username" type="text" class="form-control" placeholder="Enter username" required>
                </div>
                <div class="form-group">
                    <label for="regEmail">Email address</label>
                    <input name="email" type="email" class="form-control" aria-describedby="regEmailHelp" placeholder="Enter email" required>
                    <small id="regEmailHelp" class="form-text text-muted">We'll never share your email with anyone else without premission.</small>
                </div>
                <div class="form-group">
                    <label for="regPassw">Password</label>
                    <input name="passw" type="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label for="regPassw">Repeat Password</label>
                    <input name="passw_repeat" type="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-regUser">Register</button>
            </form>
        </div>
    </div>
</main>
<script src="assets/scripts/login.js"></script>
<?php require __DIR__.'/views/footer.php'; ?>
