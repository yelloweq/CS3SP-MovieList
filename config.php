<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();
$conn = new mysqli($_ENV['HOST_NAME'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']) or die("Connect failed: %s\n" . $conn->error);
$regenerationInterval = 1800; // every 30 min

session_start();

//refresh session id to prevent fixation attacks
if (isset($_SESSION['last_regeneration_time'])) {
    $currentTime = time();
    $timeElapsed = $currentTime - $_SESSION['last_regeneration_time'];
    if ($timeElapsed >= $regenerationInterval) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration_time'] = $currentTime;
    }
} else {
    $_SESSION['last_regeneration_time'] = time();
}

function login($username, $password)
{
    global $conn;

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($fetchedPassword);
        $stmt->fetch();

        if (password_verify($password, $fetchedPassword)) {
            return true;
        }
    }

    return false;
}

function register($username, $password)
{
    global $conn;

    $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        return false; // Username already exists
    }

    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        return true;
    }

    return false;
}

function getUserID()
{
    global $conn;

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $query = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_array($result)) {
                return $row['id'];
            }

            mysqli_stmt_close($stmt);
        }
    }

    return null;
}

function getMovieByID($id)
{
    global $conn;

    $query = "SELECT title, released_at, synopsis FROM movies WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_array($result)) {
            return $row;
        }

        mysqli_stmt_close($stmt);
    }

    return null;
}

function getAllMovies()
{
    global $conn;

    $query = "SELECT id, title, released_at, genre, synopsis FROM movies";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            return $result;
        }

        mysqli_stmt_close($stmt);
    }

    return null;
}

function getReviewsForMovie($movie_id)
{
    global $conn;

    $query = "SELECT u.username, mr.review, mr.review_date, rating FROM movie_reviews mr LEFT JOIN users u ON mr.user_id = u.id where mr.movie_id = ? AND mr.user_id IS NOT NULL";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $movie_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            return $result;
        }

        mysqli_stmt_close($stmt);
    }

    return null;
}

function IsMovieInUsersList($movie_id)
{
    global $conn;

    $userID = getUserID();

    $query = "SELECT id from user_movies WHERE user_id = ? AND movie_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ii", $userID, $movie_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        return mysqli_num_rows($result) > 0;
    }

    return false;
}

function addMovieToList($movie_id)
{
    global $conn;

    $userID = getUserID();

    if (IsMovieInUsersList($movie_id)) {
        echo '<script type="text/javascript">',
        'alert("Movie is already in your list.");',
        '</script>';
    } else {

        $query = "INSERT INTO user_movies (movie_id, user_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ii", $movie_id, $userID);

            if (!mysqli_stmt_execute($stmt)) {
                echo "Error adding movie: " . $movie_id . " " . mysqli_error($conn);
            }

            mysqli_stmt_close($stmt);
        }
    }
}

function searchMovieByTitle($title)
{
    global $conn;

    $userID = getUserID();

    $query = "SELECT m.id, m.title, m.genre, m.released_at, m.synopsis FROM movies m LEFT JOIN user_movies um ON m.id = um.movie_id AND um.user_id = ? WHERE m.title LIKE ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        $searchTitle = "%" . $title . "%";
        mysqli_stmt_bind_param($stmt, "is", $userID, $searchTitle);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        return $result;
    }

    return null;
}

function getUserMovies()
{
    global $conn;

    $userID = getUserID();

    $query = "SELECT m.title, m.released_at, m.synopsis FROM movies m JOIN user_movies um ON m.id = um.movie_id WHERE um.user_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $userID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        return $result;
    }

    return null;
}


function addReviewForMovie($movie_id, $review, $rating)
{
    global $conn;

    $userID = getUserID();
    $query = "INSERT INTO movie_reviews (user_id, movie_id, review, rating) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iisi", $userID, $movie_id, $review, $rating);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    } else {
        return false;
    }
}

function addMovie($title, $genre, $synopsis, $released_at)
{
    global $conn;
    $isAdmin = $_SESSION['username'] === 'admin';
    $query = "INSERT INTO movies (title, genre, synopsis, released_at) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt && $isAdmin) {
        mysqli_stmt_bind_param($stmt, "iisi", $userID, $movie_id, $review, $rating);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    } else {
        return false;
    }
}

function deleteMovie($movie_id)
{
    global $conn;

    $isAdmin = $_SESSION['username'] === 'admin';
    $query = "DELETE FROM movies WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt && $isAdmin) {
        mysqli_stmt_bind_param($stmt, "i", $movie_id);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    } else {
        return false;
    }
}
