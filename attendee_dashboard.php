<?php
session_start();
require 'db.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'attendee') {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch registered events
$stmt = $conn->prepare("
    SELECT r.Id AS RegistrationId, e.*
    FROM Registrations r
    JOIN Events e ON r.EventId = e.Id
    WHERE r.UserId = ?
");
$stmt->execute([$userId]);
$registeredEvents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <title>My Registered Events</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard">
  <div class="container">
    <h1>🧾 My Registered Events</h1>
    <p>Hi, <strong><?php echo $_SESSION['email']; ?></strong>!</p>
    <a href="events.php">Back to Events</a> | <a href="logout.php" class="logout">Logout</a>

    <?php if (count($registeredEvents) > 0): ?>
      <ul class="event-list">
        <?php foreach ($registeredEvents as $event): ?>
          <li>
            <strong><?php echo htmlspecialchars($event['Title']); ?></strong><br>
            <span><?php echo $event['Date']; ?> at <?php echo htmlspecialchars($event['Location']); ?></span><br>
            <a href="unregister_event.php?id=<?php echo $event['RegistrationId']; ?>" onclick="return confirm('Unregister from this event?');">❌ Cancel</a>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>You have not registered for any events yet.</p>
    <?php endif; ?>
  </div>
</body>
</html>
