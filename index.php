<?php
$title = "Home";
include 'config.php';
include 'base.php';
$allMovies = getAllMovies();
?>
<div class="content">
    <p>Your personal movie list, created to easily store and remember the movies you've watched.</p>
    <p>No more scrolling your favourite subscription service to land on a movie you've already seen!</p>

    <?php
    while ($movie = mysqli_fetch_array($allMovies)) {
    ?>
        <a href="/movie.php?id=<?php echo $movie['id']; ?>">
            <?php echo $movie['title'] . ' ' . $movie['released_at'] . "\n"; ?>
        </a>
    <?php
    }
    ?>
</div>