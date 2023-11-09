<?php
include('../config.php');
$movie = getMovieByID($_GET['id']);
$title = $movie['title'];
include('../base.php');

$movie = getMovieByID($_GET['id']);
$reviews = getReviewsForMovie($_GET['id']);

$request_method = strtoupper($_SERVER['REQUEST_METHOD']);

if ($request_method === 'POST') {
    if (isset($_SESSION['username']) && isset($_POST['user-review']) && isset($_POST['rating']) && isset($_GET['id'])) {
        $movieID = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $review = htmlspecialchars($_POST['user-review'], ENT_QUOTES, 'UTF-8');
        $rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);
        verifyCSRF($_POST['CSRF']);
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
                $username = htmlspecialchars($review['username'], ENT_QUOTES, 'UTF-8');
                $rating = htmlspecialchars($review['rating'], ENT_QUOTES, 'UTF-8');
                $review_date = htmlspecialchars($review['review_date'], ENT_QUOTES, 'UTF-8');
                $review_text = htmlspecialchars($review['review'], ENT_QUOTES, 'UTF-8');

                echo '<span class="username">' . $username . "'s review - Score:" . $rating . "</span> <br> Date Added:" . $review_date . "<br>";
                echo '<span class="reviewtxt">' . $review_text . "</span><br>";
            }
        }

        ?>
    </section>
    <div class="content">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="field-row-stacked" style="width: 80%; text-align: center; display: flex; flex-direction: column; align-items: center;">
                <label for="user-review" style="display: block;">Add a review</label>
                <textarea name="user-review" id="user-review" rows="8" style="width: 100%;"></textarea>
                <label for="rating">Rating:</label>
                <input type="range" id="rating" name="rating" min="1" max="5" value="3" oninput="updateRatingValue(this.value)" style="width:50%;">
                <p>Rating: <span id="ratingValue">3</span></p>
                
            </div>
            <input type="hidden" name="CSRF" value="<?php echo $_SESSION['CSRF']; ?>">
            <button <?php if (!isset($_SESSION['username'])) echo 'disabled' ?> type="submit" style="display: block; margin: 2% auto;">Post</button>
        </form>
    </div>
</div>

<script>
    function updateRatingValue(val) {
        document.getElementById('ratingValue').textContent = val;
    }
</script>
</html>