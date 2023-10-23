
<?php 
    include("config.php");
    session_start();

    if (isset($_SESSION['username']) || $_SESSION['login']) {
        header("location:/");
        exit();
    }

    $usernameErr = $passwordErr = $confirmErr = $successMsg = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty($_POST['username'])) {
            $usernameErr = "Username is required";
        }
        if (empty($_POST['password'])) {
            $passwordErr = "password is required";
        }
        if (empty($_POST['confirm-password'])) {
            $confirmErr = "password confirmation is required";
        }
        if ($_POST['password'] !== $_POST['confirm-password']) {
            $confirmErr = "Passwords do not match";
        }


        $username = htmlspecialchars($_POST['username']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $signupTimestamp = date('Y-m-d H:i:s');

        $sqlCheckUsername = "SELECT * FROM users WHERE username = '$username'";

        $sqlRegisterUser = "INSERT INTO users (username, password, sign_up_date) VALUES ('$username', '$password', '$signupTimestamp')";


        $usernameCheckResult = mysqli_query($conn, $sqlCheckUsername);

        if (mysqli_num_rows($usernameCheckResult) > 0) {
            $usernameErr = "This username is taken.";
        } else {
            if ($conn->query($sqlRegisterUser) === TRUE) {
                $successMsg = "Account created successfully!";
                session_start();
                $_SESSION['login'] = true;
                $_SESSION['username'] = $username;
                sleep(1);
                header("Location:/");
                die();
            } else {
                echo "Error: ".$sql."</br>".$conn->error;
            }
        }
        $conn->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MovieList</title>
</head>
<style>
    .navbar {
        display:flex;
        justify-content: space-between;
    }

    .nav__routes {
        display: block;
    }
    .nav__auth {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
    }
    .form {
        display: flex;
        flex-direction: column;
        justify-content: center;
        justify-items: center;
        vertical-align: middle;
    }
</style>
<body>
    <nav>
        <div class="navbar">
            <div class="nav__routes">
                <a href="/">Home</a>
            </div>
            <div class="nav__auth">
                <a href="register.php">Register</a>
            </div>
        </div>
    </nav>
    <div class="form">
    <h2>Register</h2> 
    <p>Create an account to create your personal movie list</p>
        <form method="POST"> 
            <label for="username">Username:</label><br> 
            <input type="text" id="username" name="username"><br> 
            <span class="error"><?php echo $usernameErr;?></span><br>
            <label for="password">Password:</label><br> 
            <input type="password" id="password" name="password"><br>
            <span class="error"><?php echo $passwordErr;?></span><br>
            <label for="confirm-password">Confirm password:</label><br> 
            <input type="password" id="confirm-password" name="confirm-password"><br>
            <span class="error"><?php echo $confirmErr;?></span><br>
            <input type="submit" value="Submit"> 
        </form>
        <span class="error"><?php echo $successMsg;?></span><br>
    </div>
</body>
</html>
