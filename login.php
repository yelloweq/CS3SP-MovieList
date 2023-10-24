<?php ob_start();
$title = "Login";
include('base.php');
include("config.php");

if (isset($_SESSION['username']) && $_SESSION['login']) {
    header("location:/");
    exit();
}

$usernameErr = $passwordErr = $confirmErr = $successMsg = "";

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['username'])) {
        $usernameErr = "Username is required";
    }
    if (empty($_POST['password'])) {
        $passwordErr = "password is required";
    }


    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $signupTimestamp = date('Y-m-d H:i:s');

    $sqlRegisterUser = "INSERT INTO users (username, password, sign_up_date) VALUES ('$username', '$password', '$signupTimestamp')";

    if ($conn->query($sqlRegisterUser) === TRUE) {
        $successMsg = "Account created successfully!";
        session_start();
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        sleep(1);
        header("Location:/");
        die();
    } else {
        echo "Error: " . $sql . "</br>" . $conn->error;
    }

    $conn->close();
}
?>
<style>
    .form label {
        display: inline-block;
        width: 100px;
        margin-right: 10px;
        text-align: right;
    }

    .form input[type="submit"] {
        display: block;
        margin: 0 auto;
        width: 100px;
        height: 32px;
        font-size: 14px;
    }
</style>
<div style="width: 50%; margin: 0 auto;">
    <h1 style="text-align: center;">Login</h1>
    <div style="width: 50%; margin: 0 auto;" class="form">
        <p>Login to view your personal movie list</p>
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username"><br>
            <span class="error"><?php echo $usernameErr; ?></span><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password"><br>
            <span class="error"><?php echo $passwordErr; ?></span><br>
            <input style=" display: block; margin: 0 auto;" type="submit" value="Submit">
        </form>
        <span class="error"><?php echo $successMsg; ?></span><br>
    </div>
    </body>

    </html>