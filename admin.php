<?php
// admin.php — shows all users
session_start();
include "db.php";

// require login
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT id, userid, fullname FROM users ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Admin - Users</title>
  <link rel="stylesheet" href="styles.css" />
  <style>
    .table { width: 90%; max-width: 900px; margin: 20px auto; border-collapse: collapse; }
    .table th, .table td { padding: 10px 12px; border: 1px solid #ddd; text-align:center; }
    .topbar { text-align:center; margin-top: 12px; }
  </style>
</head>
<body>
  <main>
    <div class="topbar">
      <h2>Registered Users</h2>
      <a class="nav-btn" href="index.php">Home</a>
      <a class="nav-btn" href="logout.php">Logout</a>
    </div>

    <table class="table">
      <tr>
        <th>ID</th>
        <th>User ID</th>
        <th>Full Name</th>
      </tr>
      <?php while($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?= htmlspecialchars($row['id']) ?></td>
        <td><?= htmlspecialchars($row['userid']) ?></td>
        <td><?= htmlspecialchars($row['fullname']) ?></td>
      </tr>
      <?php endwhile; ?>
    </table>
  </main>
</body>
</html>
