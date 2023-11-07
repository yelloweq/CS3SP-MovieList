<?php
$title = "My Movies";
include('../config.php');
include('../base.php');

if (!isset($_SESSION['username'])) {
    header("location:/login.php");
    exit();
}

$getUserMoviesResult = getUserMovies();
global $searchResult;

$queryLengthErr = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['add'])) {
        $movieID = $_POST['movie_id'];
        addMovieToList($movieID);
        header('Refresh:0');
    } elseif (isset($_POST['query']) && strlen($_POST['query']) >= $_ENV['QUERY_MIN_LENGTH']) {
        $query = htmlspecialchars($_POST['query'], ENT_QUOTES, 'UTF-8');
        $searchResult = searchMovieByTitle($query);
    } else {
        $queryLengthErr = "Please enter at least 3 characters";
    }
}
$conn->close();
?>

<div class="content">
    <?php
    if (mysqli_num_rows($getUserMoviesResult) > 0) {
    ?>
        <div style="display: flex;justify-content:center;align-items:center">
            <table>
                <tr>
                    <th>Titles</th>
                    <th>Release year</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_array($getUserMoviesResult)) {
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['released_at'], ENT_QUOTES, 'UTF-8'); ?></td>
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
    <?php echo htmlspecialchars($queryLengthErr, ENT_QUOTES, 'UTF-8'); ?>
    <form method="POST">
        <input type="text" name="query" placeholder="Search and add movies" />
        <input type="submit" value="Search">
    </form>

    <?php
    if ($searchResult && mysqli_num_rows($searchResult) > 0) {
        while ($row = mysqli_fetch_array($searchResult)) {
    ?>
            <div style="display: flex;align-items:center;justify-content:center;">
                <?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($row['genre'], ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($row['released_at'], ENT_QUOTES, 'UTF-8'); ?>

                <form method="post">
                    <?php echo '<input type="hidden" name="movie_id" value="' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '">'; ?>
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