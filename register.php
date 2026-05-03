<?php
// register.php
session_start();
include "db.php";

$msg = "";
if (isset($_POST['register'])) {
    $fullname = trim($_POST['fullname']);

    if ($fullname === "") {
        $msg = "Please enter full name.";
    } else {
        // Generate unique userid and password
        $userid = "U" . rand(10000, 99999);
        $password = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 8);

        $sql = "INSERT INTO users (userid, password, fullname) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $userid, $password, $fullname);
        if (mysqli_stmt_execute($stmt)) {
            $msg = "Registration successful. Your credentials:<br><strong>User ID:</strong> $userid<br><strong>Password:</strong> $password";
        } else {
            $msg = "Registration failed: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Register</title>
  <link rel="stylesheet" href="styles.css" />
  <style>
    /* small overrides for register page */
    .box { max-width: 420px; margin: 40px auto; padding: 20px; background: #fff; border-radius: 12px; box-shadow: 0 6px 18px rgba(0,0,0,0.08); }
    .msg { margin-top: 12px; color: #0b5; }
    .error { color: #c00; }
    a.button { display:inline-block; margin-top:12px; padding:8px 14px; background:#3c2f2f; color:#fff; border-radius:8px; text-decoration:none; }
  </style>
</head>
<body>
  <main>
    <div class="box">
      <h2>Create Account</h2>

      <form method="POST" action="">
        <label>Full Name</label><br>
        <input type="text" name="fullname" placeholder="Enter your full name" required style="width:100%;padding:8px;border-radius:6px;border:1px solid #ccc" />
        <br><br>
        <button type="submit" name="register" style="padding:10px 16px;border:none;background:#3c2f2f;color:#fff;border-radius:8px;cursor:pointer;">Register</button>
      </form>

      <?php if($msg): ?>
        <p class="<?= strpos($msg, 'failed') !== false ? 'error' : 'msg' ?>"><?= $msg ?></p>
      <?php endif; ?>

      <p style="margin-top:14px;">
        Already have account? <a href="login.php">Login here</a>
      </p>
    </div>
  </main>
</body>
</html>
