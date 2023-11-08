<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();
$conn = new mysqli($_ENV['HOST_NAME'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']) or die("Connect failed: %s\n" . $conn->error);

session_start();

function login($username, $password)
{
    global $conn;

    $sql = ("SELECT password FROM users WHERE username = '$username");
    $query = mysqli_query($conn, $sql);
    if ($user = mysqli_num_rows($query) > 0) {
        $user = mysqli_fetch_assoc($query);
        if ($password == $user['password']) {
            return true;
        }
    }

    return false;
}

function register($username, $password)
{
    global $conn;

    $sql = "SELECT username FROM users WHERE username = '$username'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        return false; 
    }

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    if (mysqli_query($conn, $sql)) {
        return true;
    }

    return false;
}

function getUserID()
{
    global $conn;

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $query = "SELECT id FROM users WHERE username = '$username'";

        $result = mysqli_query($conn, $query);

        if ($row = mysqli_fetch_array($result)) {
            return $row['id'];
        }
    }

    return null;
}

function getMovieByID($id)
{
    global $conn;

    $query = "SELECT title, released_at, synopsis FROM movies WHERE id = '$id'";


    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_array($result)) {
        return $row;
    }

    return null;
}

function getAllMovies()
{
    global $conn;

    $query = "SELECT id, title, released_at, genre, synopsis FROM movies";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        return $result;
    }

    return null;
}

function getReviewsForMovie($movie_id)
{
    global $conn;

    $query = "SELECT u.username, mr.review, mr.review_date, rating FROM movie_reviews mr LEFT JOIN users u ON mr.user_id = u.id where mr.movie_id = '$movie_id' AND mr.user_id IS NOT NULL";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        return $result;
    }

    return null;
}

function IsMovieInUsersList($movie_id)
{
    global $conn;

    $user_id = getUserID();

    $query = "SELECT id from user_movies WHERE user_id = '$user_id' AND movie_id = '$movie_id'";
    $result = mysqli_query($conn, $query);

    return mysqli_num_rows($result) > 0;
}

function addMovieToList($movie_id)
{
    global $conn;

    $user_id = getUserID();

    if (IsMovieInUsersList($movie_id)) {
        echo '<script type="text/javascript">',
        'alert("Movie is already in your list.");',
        '</script>';
    } else {
        $query = "INSERT INTO user_movies (movie_id, user_id) VALUES ('$movie_id', '$user_id')";

        if ($result = mysqli_query($conn, $query)) {
            if (!$result) {
                echo "Error adding movie: " . $movie_id . " " . mysqli_error($conn);
            }
        }
    }
}

function searchMovieByTitle($title)
{
    global $conn;

    $user_id = getUserID();
    $search_title = "%" . $title . "%";
    $query = "SELECT m.id, m.title, m.genre, m.released_at, m.synopsis FROM movies m LEFT JOIN user_movies um ON m.id = um.movie_id AND um.user_id = '$user_id' WHERE m.title LIKE '$search_title'";
    $data = mysqli_query($conn, $query);
    if ($data) {
        return $data;
    } else {
        return null;
    }
}

function getUserMovies()
{
    global $conn;

    $user_id = getUserID();

    $query = "SELECT m.title, m.released_at, m.synopsis FROM movies m JOIN user_movies um ON m.id = um.movie_id WHERE um.user_id = '$user_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        return $result;
    } else {
        return null;
    }
}


function addReviewForMovie($movie_id, $review, $rating)
{
    global $conn;

    $user_id = getUserID();
    $query = "INSERT INTO movie_reviews (user_id, movie_id, review, rating) VALUES ('$user_id', '$movie_id', '$review', '$rating')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        return $result;
    } else {
        return false;
    }
}

function addMovie($title, $genre, $synopsis, $released_at)
{
    global $conn;
    //$isAdmin = $_SESSION['username'] === 'admin';
    $query = "INSERT INTO movies (title, genre, synopsis, released_at) VALUES ('$title', '$genre', '$synopsis', '$released_at')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        return $result;
    } else {
        return false;
    }
}

function deleteMovie($movie_id)
{
    global $conn;

    //$isAdmin = $_SESSION['username'] === 'admin';
    $query = "DELETE FROM movies WHERE id = '$movie_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        return $result;
    } else {
        return false;
    }
}
