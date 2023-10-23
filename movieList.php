<?php 
    include('config.php');

    session_start();

    if (! isset($_SESSION['username']) && ! $_SESSION['login']) {
        header("location:/");
        exit();
    }
    $userID = getUserID();

    $sqlGetUserMovies = "SELECT m.title, m.released_at FROM movies m JOIN user_movies um ON m.id = um.movie_id WHERE um.user_id = '$userID'";
    $getUserMoviesResult = mysqli_query($conn, $sqlGetUserMovies);

    $queryLengthErr = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

       if (isset($_POST['add'])) {
        $movieID = $_POST['movie_id'];

        $sqlAddMovie = "INSERT INTO user_movies (movie_id, user_id) VALUES ('$movieID', '$userID')";
        if (mysqli_query($conn, $sqlAddMovie)) {
            echo "Movie added to your list.";
        } else {
            echo "userid: ". $userID;
            echo "movieid: ".$movieID;
            echo "Error adding movie: " . mysqli_error($conn);
        }
       } elseif (isset($_POST['query']) && strlen($_POST['query']) >= $_ENV['QUERY_MIN_LENGTH']) {
            $query = $_POST['query'];
            $query = htmlspecialchars($query);
            $query = mysqli_real_escape_string($conn, $query);
            $searchResult = mysqli_query($conn,"SELECT * FROM movies WHERE title LIKE '%" . $query . "%'") or die(mysqli_error($conn));
        } else {
            $queryLengthErr = "Please enter at least 3 characters";
        }
    }
    
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
        align-items: center;
        justify-content: center;
    }
    body {
        min-height: 100vh;
    }
</style>
<body>
    <nav>
        <div class="navbar">
            <div class="nav__routes">
                <a href="index.php">Home</a>
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
    if (mysqli_num_rows($getUserMoviesResult) > 0) {
    ?> 
    <div style="display: flex;justify-content:center;align-items:center">
    <table>
  <caption style="margin-bottom: 50px;">My MovieList</caption>
  <tr>
    <th>Titles</th>
    <th>Release year</th>
  </tr>
  <!-- Add remove from list button / edit button -->
  <?php
  while($row = mysqli_fetch_array($getUserMoviesResult)) {
    ?>
    <tr>
        <td><?php echo $row['title'];?></td>
        <td><?php echo $row['released_at'];?></td>
    </tr>
    <?php
    }
    ?>
    </table>
    </div>
<?php
    } else {

        ?>
        <p>Your list seems to be empty. </p>
        <br>
        <?php

    }
?>
        <br>
        <h3>Search & Add movies to your list</h3>
        <br>
        <?php echo $queryLengthErr;?>
        <form method="POST">
            <input type="text" name="query" placeholder="Search and add movies" />
            <input type="submit" value="Search">
        </form>

        <?php 
        if (mysqli_num_rows($searchResult) > 0) {
            while ($row = mysqli_fetch_assoc($searchResult)) {
                ?>
                <div style="display: flex;align-items:center;justify-content:center;">
                    <?php echo $row['title'].' '.$row['genre'].' '.$row['released_at'];?>
                    <form method="post">
                    <?php echo '<input type="hidden" name="movie_id" value="' . $row['id'] . '">'; ?>
                        <input type="submit" name="add" value="+">
                    </form>
                </div>
                 <?php 
            }
        }        
        ?>
    </div>
</body>
</html>

