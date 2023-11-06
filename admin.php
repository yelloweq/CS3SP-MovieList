<?php 
ob_start();
$title = "Admin";
include("config.php");
include('base.php');

// Check if user is logged in and is admin
if(isset($_SESSION['username']) && $_SESSION['username'] === 'admin') {

     // Delete movie form
     if(isset($_POST['delete_movie'])) {
        $movie_id = $_POST['movie_id'];
        deleteMovie($movie_id);
    }
?>
<div style="padding:20px">
    <?php
    // Display all movies
    $movies = getAllMovies();
    echo "<h2>All Movies</h2>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Title</th><th>Genre</th><th>Released At</th><th>Synopsis</th><th>Action</th></tr>";
    foreach ($movies as $movie) {
        echo "<tr>";
        echo "<td>" . $movie['id'] . "</td>";
        echo "<td>" . $movie['title'] . "</td>";
        echo "<td>" . $movie['genre'] . "</td>";
        echo "<td>" . $movie['released_at'] . "</td>";
        echo "<td>" . substr($movie['synopsis'], 0, 50) . "...</td>";
        echo "<td>";
        echo "<form method='POST'>";
        echo "<input type='hidden' name='movie_id' value='" . $movie['id'] . "'>";
        echo "<input type='submit' name='delete_movie' value='Delete'>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";

        // Add movie form
        echo "<h2>Add Movie</h2>";
        echo "<form method='POST' action='add_movie.php'>";
        echo "<label for='title'>Title:</label>";
        echo "<input type='text' name='title' id='title' required>";
        echo "<br>";
        echo "<label for='genre'>Genre:</label>";
        echo "<input type='text' name='genre' id='genre' required>";
        echo "<br>";
        echo "<label for='released_at'>Released At:</label>";
        echo "<input type='text' name='released_at' id='released_at' required>";
        echo "<br>";
        echo "<label for='synopsis'>Synopsis:</label>";
        echo "<textarea name='synopsis' id='synopsis' required></textarea>";
        echo "<br>";
        echo "<input type='submit' value='Add Movie'>";
        echo "</form>";
    
} else {
    // User is not logged in or is not admin, redirect to login page
    header("Location: /login.php");
    exit();
}
?>
</div>