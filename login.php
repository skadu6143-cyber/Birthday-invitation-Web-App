<?php
// login.php
session_start();
include "db.php";

$error = "";
if (isset($_POST['login'])) {
    $userid = trim($_POST['userid']);
    $password = trim($_POST['password']);

    if ($userid === "" || $password === "") {
        $error = "Enter both fields.";
    } else {
        $sql = "SELECT * FROM users WHERE userid=? AND password=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $userid, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $_SESSION['userid'] = $row['userid'];
            // set simple cookie for 1 hour
            if (!empty($_POST['remember'])) {
                setcookie("userid", $row['userid'], time()+3600, "/");
            }
            mysqli_stmt_close($stmt);
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid login details";
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Login</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <main>
    <div class="auth-card">
      <h2>Login</h2>

      <form method="POST" action="">
        <input type="text" name="userid" placeholder="User ID" required />
        <input type="password" name="password" placeholder="Password" required />
        <label style="font-size:0.9rem"><input type="checkbox" name="remember" /> Remember me</label>
        <button type="submit" name="login">Login</button>
      </form>

      <?php if($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <p style="margin-top:12px;">New user? <a href="register.php">Register</a></p>
    </div>
  </main>
</body>
</html>
