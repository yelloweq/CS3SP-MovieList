<?php ob_start();
$title = isset($title) ? $title : "Moviebox";
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
    <title><?php if (isset($title)) { echo $title; } ?></title>

    <link rel="stylesheet" href="https://unpkg.com/xp.css">
    <link rel="stylesheet" type="text/css" href="assets/clippy.css" media="all">
    <link rel="stylesheet" href="assets/styles.css">
</head>
<style>
    .content {
        padding: 2% 5% 2% 5%;
    }
</style>
<body style="background-color: #BFBFBF;min-height:100%; margin: 0">
<div class="window" style="width: 80vw;min-height:100%;margin: 10px  auto;">
    <nav>
        <div class="navbar">
            <div class="title-bar">
                <div class="title-bar-text"><?php if (isset($title)) { echo $title; } ?> </div>
                <div class="title-bar-controls">
                    <?php
                    if (isset($_SESSION['username'])) { ?>
                        <button aria-label="Minimize" onclick="window.location.href='index'" title="Click to Minimize"></button>
                        <button aria-label="Restore" onclick="window.location.href='movieList'" title="Go to your MovieList"></button>
                        <button aria-label="Close" onclick="window.location.href='logout'" title="Logout"></button>
                    <?php } else { ?>
                        <button aria-label="Minimize" onclick="window.location.href='index'" title="Click to Minimize"></button>
                        <button aria-label="Restore" onclick="window.location.href='login'" title="Click to Login"></button>
                        <button aria-label="Help" onclick="window.location.href='register'" title="Click to Register"></button>
                    <?php } ?>
                </div>
        </div>
    </nav>
    <?php include("clippy.php"); ?>

    