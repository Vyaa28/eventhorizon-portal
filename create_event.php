<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'organizer') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title      = $_POST['title'];
    $desc       = $_POST['description'];
    $date       = $_POST['date'];
    $location   = $_POST['location'];
    $created_by = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO Events (Title, Description, Date, Location, CreatedBy) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$title, $desc, $date, $location, $created_by]);
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Create Event</title></head>
<body>
  <h2>Create Event</h2>
  <form method="POST">
    Title: <input name="title" required><br>
    Description: <textarea name="description" required></textarea><br>
    Date: <input type="date" name="date" required><br>
    Location: <input name="location" required><br>
    <button type="submit">Create</button>
  </form>
</body>
</html>
