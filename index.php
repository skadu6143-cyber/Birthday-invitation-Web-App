<?php
// index.php — protected invitation page (your exact code content preserved)
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Birthday Invitation Card Generator</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <header class="page-header">
    <div class="header-inner">
      <div>Logged in as: <strong><?= htmlspecialchars($_SESSION['userid']) ?></strong></div>
      <div class="header-links">
        <a href="admin.php">Admin</a> |
        <a href="logout.php">Logout</a>
      </div>
    </div>
  </header>

  <main>
    <h1>🎀Birthday Invitation Card🎀</h1>

    <section id="formSection">
      <form id="invitationForm" onsubmit="return false">
        <label for="name">Your Name *</label>
        <input type="text" id="name" placeholder="Enter your name" required />

        <label for="location">Event Location *</label>
        <input type="text" id="location" placeholder="Enter event address" required />

        <label for="date">Date *</label>
        <input type="date" id="date" required />

        <label for="time">Time *</label>
        <input type="time" id="time" required />

        <label for="photo">Upload Photo (Optional)</label>
        <input type="file" id="photo" accept="image/*" />

        <button type="button" id="generateBtn">Generate Invitation</button>
      </form>
    </section>

    <section id="cardSection" class="hidden">
      <div id="invitationCard" class="card">
        <span class="shape circle"></span>
        <span class="shape triangle"></span>
        <span class="shape square"></span>

        <img id="cardPhoto" alt="Your Photo" class="card-photo hidden" />
        <h2 id="cardName" class="card-name"></h2>
        <p id="cardAddress" class="card-address"></p>
        <p class="card-details"><strong>Date:</strong> <span id="cardDate"></span></p>
        <p class="card-details"><strong>Time:</strong> <span id="cardTime"></span></p>
        <p class="card-note">You are invited to celebrate this special day! 🎂🎉</p>

        <div id="mapContainer" class="map-container hidden">
          <iframe
            id="mapFrame"
            width="100%"
            height="200"
            style="border:0"
            loading="lazy"
            allowfullscreen
            referrerpolicy="no-referrer-when-downgrade"
          ></iframe>
        </div>
      </div>
    </section>
  </main>

  <canvas id="confettiCanvas"></canvas>

  <!-- confetti library (kept as in your original) -->
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
  <script src="script.js"></script>
</body>
</html>
