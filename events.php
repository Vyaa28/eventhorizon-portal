<?php
session_start();
require 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'attendee') {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch all events
$stmt = $conn->query("SELECT * FROM Events ORDER BY Date ASC");
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch events already registered
$registeredStmt = $conn->prepare("SELECT EventId FROM Registrations WHERE UserId = ?");
$registeredStmt->execute([$userId]);
$registeredEvents = $registeredStmt->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Upcoming Events</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard">
  <div class="container">
    <h1>📅 Upcoming Events</h1>
    <p>Hello, <strong><?php echo $_SESSION['email']; ?></strong></p>
   <a href="attendee_dashboard.php" class="nav-tab">🧾 My Registered Events</a>
    <a href="logout.php" class="logout">🚪 Logout</a>
    

    <?php foreach ($events as $event): ?>
      <div class="event-card">
        <h3><?php echo htmlspecialchars($event['Title']); ?></h3>
        <p><strong>Date:</strong> <?php echo $event['Date']; ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($event['Location']); ?></p>
        <p><?php echo nl2br(htmlspecialchars($event['Description'])); ?></p>

        <?php if (in_array($event['Id'], $registeredEvents)): ?>
          <p class="registered-msg">✅ You are already registered for this event.</p>
        <?php else: ?>
          <form method="POST" action="register_event.php">
            <input type="hidden" name="event_id" value="<?php echo $event['Id']; ?>">
            <button type="submit">Register & Pay</button>
          </form>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
</body>
</html>
