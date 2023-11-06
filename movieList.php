<?php
$title = "My Movies";
include('config.php');
include('base.php');

if (!isset($_SESSION['username'])) {
    header("location:/login.php");
    exit();
}
$movies = getAllMovies();
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
        $queryLengthErr = "Please enter at least . " . $_ENV['QUERY_MIN_LENGTH'] .  "characters";
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
        foreach ($searchResult as $result) {
    ?>
            <div style="display: flex;">
            <?php
            echo "<table>";
            echo "<tr>";
            echo "<td><a href='movie.php?id=" . $result['id'] . "'>" . $result['title'] . "</a></td>";
            echo "<td>" . $result['genre'] . "</td>";
            echo "<td>" . $result['released_at'] . "</td>";
            echo "<td>" . substr($result['synopsis'], 0, 50) . "...</td>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
?>
                <form method="post">
                    <?php echo '<input type="hidden" name="movie_id" value="' . htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8') . '">'; ?>
                    <input type="submit" name="add" value="Add to List">
                </form>
            </div>
    <?php
        }
    } else {
        // Display all movies
        echo "<h3>Top 10 Movies</h3>";
        echo "<table>";
        echo "<tr><th>Title</th><th>Genre</th><th>Released At</th><th>Synopsis</th><th>Action</th></tr>";
        $counter = 0;
        foreach ($movies as $movie) {
            if ($counter >= 10) {
                break;
            }
            $counter++;
            echo "<tr>";
            echo "<td><a href='movie.php?id=" . $movie['id'] . "'>" . $movie['title'] . "</a></td>";
            echo "<td>" . $movie['genre'] . "</td>";
            echo "<td>" . $movie['released_at'] . "</td>";
            echo "<td>" . substr($movie['synopsis'], 0, 50) . "...</td>";
            echo "<td>";
            echo "<form method='POST'>";
            echo "<input type='hidden' name='movie_id' value='" . $movie['id'] . "'>";
            echo "<input type='submit' name='add' value='Add to list'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    ?>
</div>
</body>

</html>