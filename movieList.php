<?php 
    include('config.php');

    session_start();

    if (! isset($_SESSION['username']) && ! $_SESSION['login']) {
        header("location:/");
        exit();
    }

    $sqlGetUserMovies = "SELECT * FROM user_movies where user_id = '$user_id'";
    $getUserMoviesResult = mysqli_query($conn, $sqlGetUserMovies);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieList</title>
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
    <div class="content">
    <?php
    if (mysqli_num_rows($result) > 0) {
    echo $_SESSION['username']."'s"." posts:";
    $index=0;
    while($row = mysqli_fetch_array($getUserMoviesResult)) {
        $index++;
        echo $row['title'] . ' | ' . $row['release'];
    };
    } else {
        ?>
        <p>Your list seems to be empty. </p>
        <br>
        <br>
        <!-- Search component somewhere on the page where you click to add movie to your list. -->
        <?php
}
?>
    </div>
</body>
</html>

