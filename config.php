<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();
$conn = new mysqli($_ENV['HOST_NAME'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'],$_ENV['DB_NAME']) or die("Connect failed: %s\n". $conn -> error);
session_start();
function getUserID() {
    global $conn;

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $query = "SELECT id FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            return $row['id'];
        }
    }

    return null;
} 

function getMovieByID($id) {
    global $conn;


    $query = "SELECT title, released_at FROM movies WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        return $row;
    }
    
    return null;
} 

function getAllMovies() {
    global $conn;

    $query = "SELECT id, title, released_at FROM movies";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        return $result;
    }

    return null;
} 

function getReviewsForMovie($movie_id) {
    global $conn;

    $query = "SELECT u.username, mr.review FROM movie_reviews mr LEFT JOIN users u ON mr.user_id = u.id where mr.movie_id = '$movie_id' AND mr.user_id IS NOT NULL";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        return $result;
    }

    return null;
}

function IsMovieInUsersList($movie_id) {
    global $conn;

    $userID = getUserID();
    
    $query = "SELECT id from user_movies WHERE user_id = '$userID' AND movie_id ='$movie_id'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}

function addMovieToList($movie_id) {
    global $conn;

    $userID = getUserID();

    if (IsMovieInUsersList($movie_id)) {
        echo "Movie is already in your list.";
    }
    $query = "INSERT INTO user_movies (movie_id, user_id) VALUES ('$movie_id', '$userID')";
    if (!mysqli_query($conn, $query)) {
        echo "Error adding movie: " . $movie_id . " ". mysqli_error($conn);
    }
}

function searchMovieByTitle($title) {
    global $conn;

    $userID = getUserID();

    $title = htmlspecialchars($title);
    $query = "SELECT m.id, m.title, m.genre, m.released_at FROM movies m LEFT JOIN user_movies um ON m.id = um.movie_id AND um.user_id = $userID WHERE um.user_id IS NULL AND m.title LIKE '%" . $title . "%'";
    return mysqli_query($conn, $query);
}

function getUserMovies() {
    global $conn;

    $userID = getUserID();

    $query = "SELECT m.title, m.released_at FROM movies m JOIN user_movies um ON m.id = um.movie_id WHERE um.user_id = '$userID'";
    return mysqli_query($conn, $query);
}

function addReviewForMovie($movie_id, $review) {
    global $conn;

    $userID = getUserID();
    $review = htmlspecialchars($review);
    $query = "INSERT INTO movie_reviews (user_id, movie_id, review) VALUES ('$userID', '$movie_id', '$review')";
    return mysqli_query($conn, $query);
}
