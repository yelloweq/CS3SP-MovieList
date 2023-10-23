<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<?php     header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title); ?></title>

    <link rel="stylesheet" href="https://unpkg.com/xp.css">
    <link rel="stylesheet" type="text/css" href="/node_modules/clippyjsreworked/assets/clippy.css" media="all">
</head>

<body>
    <nav>
        <div class="navbar">
            <div class="title-bar">
                <div class="title-bar-text"><?php echo isset($title); ?> </div>
                <div class="title-bar-controls">
                    <?php
                    if (isset($_SESSION['username'])) { ?>
                        <button aria-label="Minimize" onclick="window.location.href='movieList.php'"></button>
                        <button aria-label="Restore" onclick="window.location.href='index.php'"></button>
                        <button aria-label="Close" onclick="window.location.href='logout.php'"></button>
                    <?php } else { ?>
                        <button aria-label="Minimize" onclick="window.location.href='movieList.php'"></button>
                        <button aria-label="Restore" onclick="window.location.href='index.php'"></button>
                        <button aria-label="Help" onclick="window.location.href='logout.php'"></button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>
</body>
<!-- Add these scripts to  the bottom of the page -->
<script src="https://unpkg.com/jquery@3.2.1"></script>
 
<script src="node_modules/clippyjsreworked/dist/clippy.js"></script>
 
<script type="text/javascript">

clippy.load('Bonzi', function(agent){
    // Do anything with the loaded agent
    agent.show();
    agent.animate();
});
</script> 