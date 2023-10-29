<?php
include('config.php');
$movie = getMovieByID($_GET['id']);
$title = $movie['title'];
include('base.php');

//throw 404 if movie is not found here

$movie = getMovieByID($_GET['id']);
$reviews = getReviewsForMovie($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['username']) && isset($_POST['user-review'])) {
        $userID = getUserID();
        $movieID = $_GET['id'];
        $review = $_POST['user-review'];
        addReviewForMovie($movieID, $review);
        header('Refresh:0');
    }
}
?>

<div class="content">
    <?php
    echo $movie['title'] . " " . $movie['released_at'] . " information";
    ?>

    <section>
        <h4>Reviews</h4>
        <?php
        if (!$reviews) {
            echo "This movie does not have any reviews yet.";
        }
        while ($review = mysqli_fetch_array($reviews)) {
            echo $review['username'] . "'s review\n";
            echo $review['review'] . "\n";
        }
        ?>
    </section>
    <form method="post">
        <div class="field-row-stacked" style="width: 200px;">
            <label for="user-review">Add a review</label>
            <textarea name="user-review" id="user-review" rows="8"></textarea>
        </div>
        <button <?php if (!isset($_SESSION['username'])) echo 'disabled' ?> type="submit">Post</button>
    </form>
</div>