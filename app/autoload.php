<?php

/*
 * This file is part of Yrgo.
 *
 * (c) Yrgo, högre yrkesutbildning.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

// Start the session engines.
session_start();
$loggedIn = isset($_SESSION['userid']);

// Set the default timezone to Coordinated Universal Time.
date_default_timezone_set('UTC');

// Set the default character encoding to UTF-8.
mb_internal_encoding('UTF-8');

// Fetch the global configuration array.
$config = require __DIR__.'/config.php';

// Setup the database connection.
$pdo = new PDO($config['database_path']);
$pdo->query('PRAGMA foreign_keys=ON');

// Include the helper functions.
require __DIR__.'/functions.php';
