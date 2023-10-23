<?php 
    require __DIR__ . '/vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
    $dotenv->load();
    session_start();
    $title = "MovieList - Home";
    include 'base.php';
?>

    <div class="content">
        <p>Your personal movie list, created to easily store and remember the movies you've watched.</p> 
        <p>No more scrolling your favourite subscription service to land on a movie you've already seen!</p>
    </div>
</body>
</html>

