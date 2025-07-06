<?php
session_start();
require 'db.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'organizer') {
    header("Location: login.php");
    exit();
}

$organizer_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM Events WHERE CreatedBy = ?");
$stmt->execute([$organizer_id]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Organizer Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard">

  <div class="container">
    <h1>🎉 Organizer Dashboard</h1>
    <p class="welcome">Welcome, <strong><?php echo $_SESSION['email']; ?></strong></p>

    <nav class="nav-links">
      <a href="create_event.php">➕ Create New Event</a>
      <!-- <a href="events.php">📅 View Events</a> -->
      <a href="logout.php" class="logout">🚪 Logout</a>
    </nav>

    <h2>Your Events:</h2>
    <?php if (count($events) > 0): ?>
      <ul class="event-list">
        <?php foreach ($events as $event): ?>
          <li>
            <strong><?php echo htmlspecialchars($event['Title']); ?></strong><br>
            <span><?php echo $event['Date']; ?> at <?php echo htmlspecialchars($event['Location']); ?></span><br>
            <a href="edit_event.php?id=<?php echo $event['Id']; ?>">✏️ Edit</a> |
            <a href="delete_event.php?id=<?php echo $event['Id']; ?>" onclick="return confirm('Delete this event?');">❌ Delete</a>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>No events created yet.</p>
    <?php endif; ?>
  </div>

</body>
</html>
