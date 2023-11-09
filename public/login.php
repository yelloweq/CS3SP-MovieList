<?php 
$title = "Login";
include("../config.php");
include('../base.php');

if (isset($_SESSION['username']) && $_SESSION['login']) {
    header("location:/");
    exit();
}

$usernameErr = $passwordErr = $confirmErr = $successMsg = $loginErr = "";
$request_method = strtoupper($_SERVER['REQUEST_METHOD']);

if ($request_method === 'POST') {
    if (empty($_POST['username'])) {
        $usernameErr = "Username is required";
    }
    if (empty($_POST['password'])) {
        $passwordErr = "password is required";
    }

    verifyCSRF($_POST['CSRF']);


    $username = $_POST['username'];
    $password = $_POST['password'];
    $loginStatus = login($username, $password);

        if ($loginStatus === true) {
            $successMsg = "Successfully logged in!";
            session_start();
            session_regenerate_id(true); // Regenerate session ID
            $_SESSION['login'] = true;
            $_SESSION['username'] = $username;
            sleep(1);
            if ($username === 'admin') {
                header("Location:/admin.php");
                die();
            }
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
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="display:flex;flex-direction:column;margin: 0 30%" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"><br>
        <span class="error"><?php echo $usernameErr; ?></span><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br>
        <span class="error"><?php echo $passwordErr; ?></span><br>
        <input type="hidden" id="CSRF" name="CSRF" value="<?php echo $_SESSION['CSRF']; ?>">
        <input style=" display: block; margin: 0 auto;" type="submit" value="Submit">
    </form>
    <span class="error"><?php echo $loginErr; ?></span><br>
    <span class="success"><?php echo $successMsg; ?></span><br>
</div>
</body>

</html>