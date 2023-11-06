<?php
include("config.php");
include('base.php');
    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the data sent via the POST request
        $title = $_POST['title'];
        $genre = $_POST['genre'];
        $released_at = $_POST['released_at'];
        $synopsis = $_POST['synopsis'];

        // Prepare the SQL statement
        $sql = "INSERT INTO movies (title, genre, released_at, synopsis) VALUES ('$title', '$genre', '$released_at', '$synopsis')";

        // Execute the SQL statement
        if ($conn->query($sql) === TRUE) {
            // Redirect the user to a success page
            header('Location: /admin.php');
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }