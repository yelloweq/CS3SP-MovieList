<?php
$title = "Home";
include '../config.php';
include '../base.php';
$allMovies = getAllMovies();
?>
<div class="content">
    <p>Your personal movie list, created to easily store and remember the movies you've watched.</p>
    <p>No more scrolling your favorite subscription service to land on a movie you've already seen!</p>

    <?php
    while ($movie = mysqli_fetch_array($allMovies)) {
        $movieId = htmlspecialchars($movie['id'], ENT_QUOTES, 'UTF-8');
        $movieTitle = htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8');
        $releasedAt = htmlspecialchars($movie['released_at'], ENT_QUOTES, 'UTF-8');
    ?>
        <a href="/movie.php?id=<?php echo $movieId; ?>">
            <?php echo $movieTitle . ' ' . $releasedAt . "\n"; ?>
        </a>
    <?php
    }
    ?>
</div>