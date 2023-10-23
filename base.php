<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo isset($title); ?></title>
<link
  rel="stylesheet"
  href="https://unpkg.com/xp.css">
</head>
<body>
    <nav>
        <div class="navbar">
            <div class="window" style="width:auto; height:20px">
                <a href="movieList.php">MyMovieList</a>
            </div>
            <?php
            if (isset($_SESSION['username'])){ ?>
                <div class="nav__auth">
                    <?php echo $_SESSION['username'];?>
                    <a href="logout.php">Log out</a>
                </div>
            <?php } else { ?>
                <div class="nav__auth">
                    <a href="login.php">Login</a>
                    <a href="register.php">Register</a>
                </div>
            <?php } ?> 
        </div>
    </nav>
</body>