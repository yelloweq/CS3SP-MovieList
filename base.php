<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $title; ?></title>
</head>
<style>
    .navbar {
        display:flex;
        justify-content: space-between;
    }

    .nav__routes {
        display: block;
    }
    .nav__auth {
        display: flex;
        justify-content: space-between;
        width: 125px;
    }
    .nav__auth a {
        display: block;
        padding: 5 15 5 5;
        text-decoration: none;
    }
    .content {
        position: relative;
        display: block;
        margin: auto;
        width: 80%;
        text-align: center;
    }
    body {
        min-height: 100vh;
    }
</style>
<body>
    <nav>
        <div class="navbar">
            <div class="nav__routes">
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