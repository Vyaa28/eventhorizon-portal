<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'organizer') {
    header("Location: login.php"); exit();
}

$eventId = $_GET['id'] ?? 0;
$organizerId = $_SESSION['user_id'];

// Fetch event
$stmt = $conn->prepare("SELECT * FROM Events WHERE Id = ? AND CreatedBy = ?");
$stmt->execute([$eventId, $organizerId]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) { echo "Event not found."; exit(); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title    = $_POST['title'];
    $desc     = $_POST['description'];
    $date     = $_POST['date'];
    $location = $_POST['location'];

    $update = $conn->prepare(
        "UPDATE Events SET Title=?, Description=?, Date=?, Location=? WHERE Id=? AND CreatedBy=?"
    );
    $update->execute([$title, $desc, $date, $location, $eventId, $organizerId]);
    header("Location: dashboard.php"); exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Event</title></head>
<body>
<h2>Edit Event</h2>
<form method="POST">
  Title: <input name="title" value="<?php echo htmlspecialchars($event['Title']); ?>" required><br>
  Description: <textarea name="description" required><?php echo htmlspecialchars($event['Description']); ?></textarea><br>
  Date: <input type="date" name="date" value="<?php echo $event['Date']; ?>" required><br>
  Location: <input name="location" value="<?php echo htmlspecialchars($event['Location']); ?>" required><br>
  <button type="submit">Save</button>
</form>
</body>
</html>
