<?php

// Database configuration
$host = "localhost";
$username = "root";
$password = "Marchewka237";
$dbname = "coursework";

error_reporting(1);

// Connect to MySQL server
$conn = mysqli_connect($host, $username, $password);

// Check connection
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (mysqli_query($conn, $sql)) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . mysqli_error($conn) . "\n";
}

// Select database
mysqli_select_db($conn, $dbname) or die('could not select ' . $dbname);

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
        synopsis TEXT,
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
    ('James', '1234', 'james@example.com'),
    ('Mary', 'password1', 'mary@example.com'),
    ('Sarah', 'password2', 'sarah@example.com'),
    ('Michael', 'password3', 'michael@example.com'),
    ('David', 'password4', 'david@example.com'),
    ('Jennifer', 'password5', 'jennifer@example.com'),
    ('Linda', 'password6', 'linda@example.com'),
    ('William', 'password7', 'william@example.com'),
    ('Robert', 'password8', 'robert@example.com'),
    ('Nancy', 'password9', 'nancy@example.com'),
    ('Karen', 'password10', 'karen@example.com'),
    ('Daniel', 'password11', 'daniel@example.com'),
    ('Susan', 'password12', 'susan@example.com'),
    ('Jeffrey', 'password13', 'jeffrey@example.com'),
    ('Matthew', 'password14', 'matthew@example.com'),
    ('Emily', 'password15', 'emily@example.com'),
    ('Jessica', 'password16', 'jessica@example.com'),
    ('Chris', 'password17', 'chris@example.com'),
    ('Andrew', 'password18', 'andrew@example.com'),
    ('Mark', 'password19', 'mark@example.com'),
    ('Kimberly', 'password20', 'kimberly@example.com'),
    ('Brian', 'password21', 'brian@example.com'),
    ('Lisa', 'password22', 'lisa@example.com'),
    ('Catherine', 'password23', 'catherine@example.com'),
    ('Paul', 'password24', 'paul@example.com'),
    ('Diana', 'password25', 'diana@example.com'),
    ('George', 'password26', 'george@example.com'),
    ('Victor', 'password27', 'VictorJesus@example.com')",

    "INSERT INTO movies (title, genre, released_at, synopsis) VALUES
    ('The Shawshank Redemption', 'Drama', '1994', 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.'),
    ('The Godfather', 'Crime', '1972', 'The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.'),
    ('The Dark Knight', 'Action', '2008', 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.'),
    ('Pulp Fiction', 'Crime', '1994', 'The lives of two mob hitmen, a boxer, a gangster and his wife, and a pair of diner bandits intertwine in four tales of violence and redemption.'),
    ('Forrest Gump', 'Drama', '1994', 'The presidencies of Kennedy and Johnson, the events of Vietnam, Watergate, and other history unfold through the perspective of an Alabama man with an IQ of 75.'),
    ('The Matrix', 'Science Fiction', '1999', 'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.'),
    ('Inception', 'Science Fiction', '2010', 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.'),
    ('Fight Club', 'Drama', '1999', 'An insomniac office worker and a devil-may-care soapmaker form an underground fight club that evolves into something much, much more.'),
    ('Gladiator', 'Action', '2000', 'A former Roman General sets out to exact vengeance against the corrupt emperor who murdered his family and sent him into slavery.'),
    ('The Lord of the Rings: The Return of the King', 'Fantasy', '2003', 'Gandalf and Aragorn lead the World of Men against Sauron\'s army to draw his gaze from Frodo and Sam as they approach Mount Doom with the One Ring.'),
    ('The Silence of the Lambs', 'Crime', '1991', 'A young F.B.I. cadet must receive the help of an incarcerated and manipulative cannibal killer to help catch another serial killer, a madman who skins his victims.'),
    ('The Good, the Bad and the Ugly', 'Western', '1966', 'A bounty hunting scam joins two men in an uneasy alliance against a third in a race to find a fortune in gold buried in a remote cemetery.'),
    ('Saving Private Ryan', 'War', '1998', 'Following the Normandy Landings, a group of U.S. soldiers go behind enemy lines to retrieve a paratrooper whose brothers have been killed in action.'),
    ('Schindler\'s List', 'Biography', '1993', 'In German-occupied Poland during World War II, industrialist Oskar Schindler gradually becomes concerned for his Jewish workforce after witnessing their persecution by the Nazis.'),
    ('The Departed', 'Crime', '2006', 'An undercover cop and a mole in the police attempt to identify each other while infiltrating an Irish gang in South Boston.'),
    ('The Green Mile', 'Crime', '1999', 'The lives of guards on Death Row are affected by one of their charges: a black man accused of child murder and rape, yet who has a mysterious gift.'),
    ('The Pianist', 'Biography', '2002', 'A Polish Jewish musician struggles to survive the destruction of the Warsaw ghetto of World War II.'),
    ('The Lord of the Rings: The Fellowship of the Ring', 'Fantasy', '2001', 'A meek Hobbit from the Shire and eight companions set out on a journey to destroy the powerful One Ring and save Middle-earth from the Dark Lord Sauron.'),
    ('The Lord of the Rings: The Two Towers', 'Fantasy', '2002', 'While Frodo and Sam edge closer to Mordor with the help of the shifty Gollum, the divided fellowship makes a stand against Sauron\'s new ally, Saruman, and his hordes of Isengard.'),
    ('Se7en', 'Crime', '1995', 'Two detectives, a rookie and a veteran, hunt a serial killer who uses the seven deadly sins as his motives.'),
    ('Goodfellas', 'Crime', '1990', 'The story of Henry Hill and his life in the mob, covering his relationship with his wife Karen Hill and his mob partners Jimmy Conway and Tommy DeVito in the Italian-American crime syndicate.'),
    ('The Usual Suspects', 'Crime', '1995', 'A sole survivor tells of the twisty events leading up to a horrific gun battle on a boat, which began when five criminals met at a seemingly random police lineup.'),
    ('The Lion King', 'Animation', '1994', 'Lion cub and future king Simba searches for his identity. His eagerness to please others and penchant for testing his boundaries sometimes gets him into trouble.'),
    ('The Avengers', 'Action', '2012', 'Earth\'s mightiest heroes must come together and learn to fight as a team if they are going to stop the mischievous Loki and his alien army from enslaving humanity.'),
    ('Avatar', 'Science Fiction', '2009', 'A paraplegic Marine dispatched to the moon Pandora on a unique mission becomes torn between following orders and protecting an alien civilization.'),
    ('Jurassic Park', 'Science Fiction', '1993', 'A pragmatic paleontologist visiting an almost complete theme park is tasked with protecting a couple of kids after a power failure causes the park\'s cloned dinosaurs to run loose.'),
    ('The Incredibles', 'Animation', '2004', 'A family of undercover superheroes, while trying to live the quiet suburban life, are forced into action to save the world.'),
    ('E.T. the Extra-Terrestrial', 'Science Fiction', '1982', 'A troubled child summons the courage to help a friendly alien escape Earth and return to his home world.'),
    ('Titanic', 'Drama', '1997', 'A seventeen-year-old aristocrat falls in love with a kind but poor artist aboard the luxurious, ill-fated R.M.S. Titanic.'),
    ('Blade Runner', 'Drama/Sci-fi', '1982', 'A blade runner must pursue and terminate four replicants who stole a ship in space and have returned to Earth to find their creator.')",

    "INSERT INTO movie_reviews (movie_id, user_id, review, rating) VALUES
    (1, 1, 'Fantastic film!',5),
    (2, 2, 'I absolutely loved this movie.',5),
    (3, 3, 'A must-see!',4),
    (4, 4,'Great acting and storyline.',1),
    (5, 5,'Incredible visuals and special effects.',5),
    (6, 6,'I can watch this movie again and again.',5),
    (7, 7,'A bit slow but thought-provoking.',2),
    (8, 8, 'Not my cup of tea, but well-made.',3),
    (9, 9, 'Outstanding performance by the lead actor.',3),
    (10, 10, 'I was moved to tears.',4),
    (11, 11, 'A fun and entertaining movie.',1),
    (12, 12, 'Perfect for a family night.',2),
    (13, 13, 'Suspenseful from start to finish.',5),
    (14, 14, 'I couldn\'t look away.',4),
    (15, 15, 'A classic that never gets old.',2),
    (16, 16, 'One of my all-time favorites.',5),
    (17, 17, 'Disappointed, expected more.',1),
    (18, 18, 'Not as good as the book.',2),
    (19, 19, 'A great comedy, lots of laughs.',4),
    (20, 20, 'Hilarious, I couldn\'t stop laughing.',3),
    (21, 21, 'A beautiful love story.',5),
    (22, 22, 'Tugged at my heartstrings.',2),
    (23, 23, 'Mind-bending and thought-provoking.',3),
    (24, 24, 'I need to watch it again to understand.',5),
    (25, 25, 'An action-packed adventure.',5),
    (26, 26, 'I was on the edge of my seat.',2),
    (27, 27, 'A powerful documentary.',4),
    (28, 28, 'Eye-opening and informative.',5),
    (29, 29, 'The best horror film I\'ve seen.',3),
    (30, 30, 'Blade Runner(1982) is epic and a forever cultural reference for its visual brilliance, deep themes, and iconic characters. Blade Runner 2049(2017) is a disaster that should be wiped from human memory because it fell short of its predecessor, with pacing issues and lack of originality. Also, Deckard is not a replicant.',5)",

    "INSERT INTO user_movies (movie_id, user_id) VALUES
    ('1', '1'),
    ('2', '2'),
    ('3', '3'),
    ('4', '4'),
    ('5', '5'),
    ('6', '6'),
    ('7', '7'),
    ('8', '8'),
    ('9', '9'),
    ('10', '10'),
    ('11', '11'),
    ('12', '12'),
    ('13', '13'),
    ('14', '14'),
    ('15', '15'),
    ('16', '16'),
    ('17', '17'),
    ('18', '18'),
    ('19', '19'),
    ('20', '20'),
    ('21', '21'),
    ('22', '22'),
    ('23', '23'),
    ('24', '24'),
    ('25', '25'),
    ('26', '26'),
    ('27', '27'),
    ('28', '28'),
    ('29', '29'),
    ('30', '30')
    ",
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
