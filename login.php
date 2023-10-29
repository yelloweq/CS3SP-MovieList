<?php ob_start();
$title = "Login";
include("config.php");
include('base.php');

if (isset($_SESSION['username']) && $_SESSION['login']) {
    header("location:/");
    exit();
}

$usernameErr = $passwordErr = $confirmErr = $successMsg = $loginErr = "";

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['username'])) {
        $usernameErr = "Username is required";
    }
    if (empty($_POST['password'])) {
        $passwordErr = "password is required";
    }


    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    $sqlLoginUser = "SELECT * FROM users WHERE username = '$username' LIMIT 1";

    $loginUserResult = mysqli_query($conn, $sqlLoginUser);
    $userData = mysqli_fetch_array($loginUserResult);;
    if (mysqli_num_rows($loginUserResult) > 0 && password_verify($password, $userData["password"])) {
        $successMsg = "Successfuly logged in!";
        session_start();
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        sleep(1);
        header("Location:/");
        die();
    } else {
        $loginErr = "The username or password is incorrect.";
    }

    $conn->close();
}
?>
<h3 style="text-align: center;">Login</h3>
<div style="width:100%;display:flex;justify-items:center;flex-direction:column;text-align:center" class="form">
    <p>Login to view your personal movie list</p>
    <form style="display:flex;flex-direction:column;margin: 0 30%" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"><br>
        <span class="error"><?php echo $usernameErr; ?></span><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br>
        <span class="error"><?php echo $passwordErr; ?></span><br>
        <input style=" display: block; margin: 0 auto;" type="submit" value="Submit">
    </form>
    <span class="error"><?php echo $loginErr; ?></span><br>
    <span class="success"><?php echo $successMsg; ?></span><br>
</div>
</body>

</html>