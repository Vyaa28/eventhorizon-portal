<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'organizer') {
    header("Location: login.php"); exit();
}

$eventId = $_GET['id'] ?? 0;
$organizerId = $_SESSION['user_id'];

$stmt = $conn->prepare("DELETE FROM Events WHERE Id = ? AND CreatedBy = ?");
$stmt->execute([$eventId, $organizerId]);

header("Location: dashboard.php");
exit();
?>
