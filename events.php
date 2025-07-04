<?php
session_start();
require 'db.php';

$events = $conn->query("SELECT * FROM Events")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST" && $_SESSION['role'] === 'attendee') {
    $event_id = $_POST['event_id'];
    $user_id  = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO Registrations (UserId, EventId) VALUES (?, ?)");
    $stmt->execute([$user_id, $event_id]);
    echo "<p>Registered successfully!</p>";
}
?>
<!DOCTYPE html>
<html>
<head><title>All Events</title></head>
<body>
  <h2>Upcoming Events</h2>
  <?php foreach ($events as $row): ?>
    <div>
      <h3><?php echo htmlspecialchars($row['Title']); ?></h3>
      <p><?php echo htmlspecialchars($row['Description']); ?></p>
      <p><b>Date:</b> <?php echo $row['Date']; ?> | <b>Location:</b> <?php echo htmlspecialchars($row['Location']); ?></p>
      <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'attendee'): ?>
        <form method="POST">
          <input type="hidden" name="event_id" value="<?php echo $row['Id']; ?>">
          <button type="submit">Register</button>
        </form>
      <?php endif; ?>
    </div><hr>
  <?php endforeach; ?>
</body>
</html>
