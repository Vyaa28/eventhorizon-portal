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
<head><title>Dashboard</title></head>
<body>
  <h2>Organizer Dashboard</h2>
  <p>Welcome, <?php echo $_SESSION['email']; ?>!</p>
  <a href="create_event.php">Create New Event</a> | <a href="events.php">View Events</a> | <a href="logout.php">Logout</a>
  <h3>Your Events:</h3>
  <ul>
    <?php foreach ($events as $event): ?>
      <li><?php echo htmlspecialchars($event['Title']) . " on " . $event['Date']; ?></li>
    <?php endforeach; ?>
  </ul>
</body>
</html>
