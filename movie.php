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
        $rating = $_POST['rating'];
        addReviewForMovie($movieID, $review, $rating);
        header('Refresh:0');
    }
}
?>

<div class="content">
    <h2><?php echo $movie['title'] . ' - ' . $movie['released_at'] ?></h2>
    <p><?php echo $movie['synopsis'] ?></p>
    <section>
        <h4>Reviews</h4>
        <?php
        if (!$reviews) {
            echo "This movie does not have any reviews yet.";
        } else {
            while ($review = mysqli_fetch_array($reviews)) {
                echo '<span class="username">' . $review['username'] . "'s review - Score:" . $review['rating'] . "</span> <br> Date Added:" . $review['review_date'] . "<br>";
                echo '<span class="reviewtxt">' . $review['review'] . "</span><br>";
            }
        }
        ?>
    </section>
    <div class="content">
    <form method="post">
        <div class="field-row-stacked" style="width: 80%; text-align: center; display: flex; flex-direction: column; align-items: center;">
            <label for="user-review" style="display: block;">Add a review</label>
            <textarea name="user-review" id="user-review" rows="8" style="width: 100%;"></textarea>
            <label for="rating">Rating:</label>
            <input type="range" id="rating" name="rating" min="1" max="5" value="3" oninput="updateRatingValue(this.value)" style="width:50%;">
            <p>Rating: <span id="ratingValue">3</span></p>
        </div>
        
        <button <?php if (!isset($_SESSION['username'])) echo 'disabled' ?> type="submit" style="display: block; margin: 2% auto;">Post</button>
    </form>
</div>
</div>

<script>
    function updateRatingValue(val) {
        document.getElementById('ratingValue').textContent = val;
    }
</script>