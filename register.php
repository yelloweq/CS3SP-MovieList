<?php session_start();
ob_start();
include("config.php");
$title = "Sign up";
include("base.php");

if (isset($_SESSION['username']) && $_SESSION['login']) {
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
            $_SESSION['login'] = true;
            $_SESSION['username'] = $username;
            sleep(1);
            header("Location:/");
            die();
        } else {
            echo "Error: " . $sql . "</br>" . $conn->error;
        }
    }
    $conn->close();
}

?>
<h3 style="text-align: center;">Register</h3>
    <div style="width:100%;display:flex;justify-items:center;flex-direction:column;text-align:center" class="form">
    <p>Create an account to create your personal movie list</p>
    <form style="display:flex;flex-direction:column;margin: 0 30%" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"><br>
        <span class="error"><?php echo $usernameErr; ?></span><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br>
        <span class="error"><?php echo $passwordErr; ?></span><br>
        <label for="confirm-password">Confirm password:</label>
        <input type="password" id="confirm-password" name="confirm-password"><br>
        <span class="error"><?php echo $confirmErr; ?></span><br>
        <input style=" display: block; margin: 0 auto;" type="submit" value="Submit">
    </form>
    <span class="error"><?php echo $successMsg; ?></span><br>
    </div>
</div>
</body>
</html>