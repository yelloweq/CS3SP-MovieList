<?php

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'test';

// Connect to MySQL server
$conn = mysqli_connect($host, $username, $password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (mysqli_query($conn, $sql)) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . mysqli_error($conn) . "\n";
}

// Select database
mysqli_select_db($conn, $dbname);

// Table statements
$sql_statements = array(
    "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(50) UNIQUE,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci",
    "CREATE TABLE IF NOT EXISTS movies (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        genre VARCHAR(255) NOT NULL,
        released_at YEAR(4) NOT NULL
    )CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci",
    "CREATE TABLE IF NOT EXISTS movie_reviews (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        movie_id INT(6) UNSIGNED NOT NULL,
        user_id INT(6) UNSIGNED NOT NULL,
        review TEXT,
        rating INT(1) NOT NULL,
        review_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci",
    "CREATE TABLE IF NOT EXISTS user_movies (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        movie_id INT(6) UNSIGNED NOT NULL,
        user_id INT(6) UNSIGNED NOT NULL,
        date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci"
);

// Loop over SQL statements and execute them
foreach ($sql_statements as $sql) {
    if (mysqli_query($conn, $sql)) {
        echo "Table created successfully\n";
    } else {
        echo "Error creating table: " . mysqli_error($conn) . "\n";
    }
}

// Insert sample data
$sql_statements = array(
    "INSERT INTO users (username, password, email) VALUES
    ('John', '1234', 'john@example.com'),
    ('Joe', '1234', 'joe@example.com'),
    ('James', '1234', 'james@example.com'
    )",
    "INSERT INTO movies (title, genre, released_at) VALUES
    ('The Shawshank Redemption', 'Drama', '1994'),
    ('The Godfather', 'Crime', '1972'),
    ('The Dark Knight', 'Action', '2008'
    )",
    "INSERT INTO movie_reviews (movie_id, user_id, review) VALUES
    ('1', '1', 'wow!'),
    ('1', '2', 'This is a bad movie!'),
    ('1', '3', 'This is a great movie!'
    )",
    "INSERT INTO user_movies (movie_id, user_id) VALUES
    ('1', '1'),
    ('1', '2'),
    ('1', '3')"
);
// Loop over SQL statements and execute them
foreach ($sql_statements as $sql) {
    if (mysqli_query($conn, $sql)) {
        echo "Data inserted successfully\n";
    } else {
        echo "Error inserting data: " . mysqli_error($conn) . "\n";
    }
}

// Close connection
mysqli_close($conn);