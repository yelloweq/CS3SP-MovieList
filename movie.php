<?php 
include('config.php');
$movie = getMovieByID($_GET['id']);
$title = $movie['title'];
include ('base.php');

//throw 404 if movie is not found here

$movie = getMovieByID($_GET['id']);
$reviews = getReviewsForMovie($_GET['id']);

//add check if user already has a review for the movie & add edit review
//functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['username']) && isset($_POST['user-review'])) {
        $userID = getUserID();
        $movieID = $_GET['id'];
        $review = htmlspecialchars($_POST['user-review']);
        $sqlAddReview = "INSERT INTO movie_reviews (user_id, movie_id, review) VALUES ('$userID', '$movieID', '$review')";
        
        if (mysqli_query($conn, $sqlAddReview)) {
            echo "Review added successfuly";
            header("Refresh:0");
        } else {
            echo "Error adding review: " . mysqli_error($conn);
        }
    }
}
?>

<div class="content">
    <?php 
        echo $movie['title']." ".$movie['released_at'] . " information";
    ?>

    <section>
    <h4>Reviews</h4>
    <?php
    if (empty($reviews)) {
        echo "This movie does not have any reviews yet.";
    }
    while ($review = mysqli_fetch_array($reviews)) {
        echo $review['username']."'s review\n";
        echo $review['review']."\n";
    }
    ?>
    </section>
    <form method="post">
        <div class="field-row-stacked" style="width: 200px;">
            <label for="user-review">Add a review</label>
            <textarea name="user-review" id="user-review" rows="8"></textarea>
        </div>
        <button <?php if(!isset($_SESSION['username'])) echo 'disabled' ?> type="submit">Post</button>
    </form>
</div>
