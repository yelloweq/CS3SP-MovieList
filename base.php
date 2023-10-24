<?php ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<?php     
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header('Content-Type: text/html; charset=utf-8');
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title); ?></title>

    <link rel="stylesheet" href="https://unpkg.com/xp.css">
    <link rel="stylesheet" type="text/css" href="assets/clippy.css" media="all">
</head>
<body style="background-color: #BFBFBF;">
<div class="window" style="width: 50%; margin: 0 auto;">
    <nav>
        <div class="navbar">
            <div class="title-bar">
                <div class="title-bar-text"><?php echo isset($title); ?> </div>
                <div class="title-bar-controls">
                    <?php
                    if (isset($_SESSION['username'])) { ?>
                        <button aria-label="Minimize" onclick="window.location.href='movieList.php'"></button>
                        <button aria-label="Restore" onclick="window.location.href='index.php'"></button>
                        <button aria-label="Close" onclick="window.location.href='login.php'"></button>
                    <?php } else { ?>
                        <button aria-label="Minimize" onclick="window.location.href='movieList.php'"></button>
                        <button aria-label="Restore" onclick="window.location.href='index.php'"></button>
                        <button aria-label="Help" onclick="window.location.href='register.php'"></button>
                    <?php } ?>
                </div>
        </div>
    </nav>
    <?php include("clippy.php"); ?>