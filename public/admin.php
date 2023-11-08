<?php 
ob_start();
$title = "Admin";
include("../config.php");
include('../base.php');

$request_method = strtoupper($_SERVER['REQUEST_METHOD']);

// Check if user is logged in and is admin
if(isset($_SESSION['username']) && $_SESSION['username'] === 'admin') {

     // Delete movie form
     if(isset($_POST['delete_movie'])) {
        verifyCSRF($_POST['CSRF']);
        $movie_id = $_POST['movie_id'];
        deleteMovie($movie_id);
        header("Refresh:0");
    }

    if(isset($_POST['add_movie'])) {
        verifyCSRF($_POST['CSRF']);
        $title = $_POST['title'];
        $genre = $_POST['genre'];
        $released_at = $_POST['released_at'];
        $synopsis = $_POST['synopsis'];

        addMovie($title, $genre, $synopsis, $released_at);

        header("Refresh:0");
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
        echo "<form action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' method='POST'>";
        echo "<input type='hidden' name='movie_id' value='" . $movie['id'] . "'>";
        echo '<input type="hidden" name="CSRF" value="' . $_SESSION['CSRF'] . '">';
        echo "<input type='submit' name='delete_movie' value='Delete'>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";

        // Add movie form
        echo "<h2>Add Movie</h2>";
        echo "<form action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' method='POST'>";
        echo "<input type='hidden' name='add_movie' value='Add'";
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
        echo '<input type="hidden" name="CSRF" value="' . $_SESSION['CSRF'] . '">';
        echo "<input type='submit' value='Add Movie'>";
        echo "</form>";
    
} else {
    // User is not logged in or is not admin, redirect to login page
    header("Location: /login.php");
    exit();
}
?>
</div>