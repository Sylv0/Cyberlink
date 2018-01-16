<?php
declare(strict_types=1);
require(__DIR__.'/../app/autoload.php');
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/styles/styles.css">
    <link rel="shortcut icon" type="image/png" href="https://assets.ngin.com/site_files/5591/favicon.ico"/>
  </head>
  <body>
    <?php if(isset($_SESSION['userid'])): ?>
    <div data-userid="<?php echo $_SESSION['userid'] ?>"></div>
    <?php endif; ?>
    <?php require(__DIR__.'/navbar.php'); ?>